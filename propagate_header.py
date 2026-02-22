import os
import re

# =========================================================
# CONFIGURATION
# =========================================================
BASE_DIR = r"c:\Users\prati\Downloads\GBASE new"
# Using index.html as the source of truth now
INDEX_FILE = os.path.join(BASE_DIR, "index.html")

# The comment markers wrapper entire header block (Top Bar -> Desktop Header -> Mobile Header -> Mobile Drawer)
# Based on file inspection:
START_MARKER = '<!-- ===================== TOP BAR ===================== -->'
# We need to find where the Mobile Layout ends. Looking at the last view_file, 
# The mobile drawer is at line 418. It ends around line 465 (Menu Sidebar).
# Let's read the extracted header content first to be sure.
# I will use a REGEX to extract from START_MARKER until "<!-- Menu Sidebar Section Start -->" 
# because that seems to be the next logical section.

def read_file(path):
    with open(path, 'r', encoding='utf-8') as f:
        return f.read()

def write_file(path, content):
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

def extract_header_block(content):
    # Find start
    start_idx = content.find(START_MARKER)
    if start_idx == -1:
        print("Error: Could not find start marker in index.html")
        return None
    
    # Find end (Menu Sidebar Section Start seems to be the boundary)
    end_marker = '<!-- Menu Sidebar Section Start -->'
    end_idx = content.find(end_marker)
    
    if end_idx == -1:
        # Fallback if specific marker missing, try checking for body-overlay or hero
        end_idx = content.find('<div class="body-overlay"></div>')
    
    if end_idx == -1:
         print("Error: Could not find end marker in index.html")
         return None

    return content[start_idx:end_idx]

def adjust_paths_for_subfolder(html_content):
    # This function adjusts paths for files in strict subfolders (like product/)
    # It assumes the source HTML has paths relative to root (e.g. href="index.html" or src="images/...")
    
    # 1. Handle root-relative links (starting with /) - Remove the slash + add ../
    # E.g. href="/pre-process.html" -> href="../pre-process.html"
    # E.g. src="/images/logo.png" -> src="../images/logo.png"
    
    def replacer_root(match):
        # match.group(1) is attribute (href=|src=)
        # match.group(2) is quote
        # match.group(3) is path without slash
        return f'{match.group(1)}{match.group(2)}../{match.group(3)}'

    # Regex for href="/..." or src="/..."
    # We look for (href=|src=)(['"])/([^'"]+)
    html_content = re.sub(r'(href=|src=)(["\'])/([^"\']+)', replacer_root, html_content)

    # 2. Handle relative links that DON'T start with slash (e.g. href="index.html")
    # For a subfolder, these need ../ prepended.
    # Exclude http/https/mailto/tel/#
    
    def replacer_relative(match):
        attr = match.group(1) # href=
        quote = match.group(2) # "
        link = match.group(3) # index.html
        
        if link.startswith(('http', 'mailto', 'tel', '#', '../')):
            return match.group(0) # No change
        
        return f'{attr}{quote}../{link}{quote}'

    # Simple regex for attributes
    # Note: this is a bit aggressive but valid for this specific clean codebase
    html_content = re.sub(r'(href=|src=)(["\'])([^"\']+(?:\.html|\.png|\.jpg|\.css|\.js))(["\'])', replacer_relative, html_content)
    
    return html_content

def main():
    print(f"Reading {INDEX_FILE}...")
    index_content = read_file(INDEX_FILE)
    
    header_block = extract_header_block(index_content)
    if not header_block:
        return

    print("Header block extracted successfully.")

    # Iterate over all HTML files
    for root, dirs, files in os.walk(BASE_DIR):
        for file in files:
            if file.endswith(".html") and not (root == BASE_DIR and file == "index.html"):
                file_path = os.path.join(root, file)
                print(f"Processing {file_path}...")
                
                target_content = read_file(file_path)
                
                # Determine if we are in a subfolder (depth check)
                # BASE_DIR count parts vs root count parts
                rel_path = os.path.relpath(root, BASE_DIR)
                is_subfolder = rel_path != "."
                
                # Prepare the header block for this file
                current_header_block = header_block
                
                if is_subfolder:
                    current_header_block = adjust_paths_for_subfolder(current_header_block)
                else:
                    # Even for root files, we must remove leading slashes if they exist in index.html
                    # to make them work locally relative.
                    # e.g. href="/contact.html" -> href="contact.html"
                     current_header_block = re.sub(r'(href=|src=)(["\'])/([^"\']+)', r'\1\2\3', current_header_block)

                # Now replace the content in target file
                # Logic: Find START_MARKER and End Marker in target file
                # If target file doesn't have these markers, we might fail or need heuristic
                # Usually we expect them to exist if it's the same template.
                
                # HACK: If markers don't exist, we might be overwriting a messy file.
                # Let's try to replace from START_MARKER to <!-- Menu Sidebar Section Start -->
                
                start_idx = target_content.find(START_MARKER)
                end_marker = '<!-- Menu Sidebar Section Start -->'
                end_idx = target_content.find(end_marker)
                
                # Fallback end marker if the main one is missing
                if end_idx == -1:
                    # Some files might use 'breadcrumb-area' start as the next block
                    end_idx = target_content.find('<div class="breadcrumb-area"')
                if end_idx == -1:
                    # Final fallback: Look for whatever comes after the mobile drawer in source, which is overlay
                    end_idx = target_content.find('<!-- Menu Sidebar Section Start -->') 
                    # Actually let's try to match the last tag of our header block
                    # But safest relies on the next BIG section comment.

                if start_idx != -1 and end_idx != -1:
                    # Basic safety check: start should be before end
                    if start_idx < end_idx:
                        new_content = target_content[:start_idx] + current_header_block + target_content[end_idx:]
                        write_file(file_path, new_content)
                        print("  >> Updated successfully.")
                    else:
                        print("  >> Error: Start marker found AFTER end marker. File structure likely broken.")
                else:
                    print(f"  >> Warning: Markers not found. Start: {start_idx}, End: {end_idx}")
                    # If start is found but end is not, we are in trouble.
                    if start_idx != -1 and end_idx == -1:
                         # Try very aggressive fallback: 
                         # If we see <div class="menu-sidebar-area"> use that
                         end_idx_fallback = target_content.find('<div class="menu-sidebar-area">')
                         if end_idx_fallback != -1:
                             new_content = target_content[:start_idx] + current_header_block + target_content[end_idx_fallback:]
                             write_file(file_path, new_content)
                             print("  >> Updated using fallback marker (menu-sidebar-area div).")

if __name__ == "__main__":
    main()
