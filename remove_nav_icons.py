import os
import re

files = [
    r"c:\Users\prati\Downloads\GBASE new\index.html",
    r"c:\Users\prati\Downloads\GBASE new\contact.html",
    r"c:\Users\prati\Downloads\GBASE new\product.html",
    r"c:\Users\prati\Downloads\GBASE new\equipments.html",
    r"c:\Users\prati\Downloads\GBASE new\spare_parts.html",
    r"c:\Users\prati\Downloads\GBASE new\service.html",
    r"c:\Users\prati\Downloads\GBASE new\consulting.html",
    r"c:\Users\prati\Downloads\GBASE new\pre-process.html",
    r"c:\Users\prati\Downloads\GBASE new\freezing.html",
    r"c:\Users\prati\Downloads\GBASE new\heating.html",
    r"c:\Users\prati\Downloads\GBASE new\sorting.html",
    r"c:\Users\prati\Downloads\GBASE new\product\plate-freezer.html",
    r"c:\Users\prati\Downloads\GBASE new\product\carton-box-freezer.html",
    r"c:\Users\prati\Downloads\GBASE new\product\spiral-freezer.html",
    r"c:\Users\prati\Downloads\GBASE new\product\contact-freezer.html"
]

# Regex to remove the specific icons we added.
# We added <i class="fa-solid fa-..." style="margin-right:5px;"></i>
# Pattern: <i class="fa-solid [^"]+" style="margin-right:5px;"></i>\s*
def remove_icons(content):
    # This regex matches the <i> tag with the specific style we added, followed by optional whitespace
    pattern = r'<i class="fa-solid [^"]+" style="margin-right:5px;"></i>\s*'
    return re.sub(pattern, '', content)

for file_path in files:
    try:
        if not os.path.exists(file_path):
             continue
             
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
            
        updated_content = remove_icons(content)
            
        if updated_content != content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(updated_content)
            print(f"Cleaned {file_path}")
        else:
            print(f"No icons found in {file_path}")

    except Exception as e:
        print(f"Error processing {file_path}: {e}")
