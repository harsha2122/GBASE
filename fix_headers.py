import os
import re

def fix_header_paths(file_path, depth):
    """Fix image paths in header based on file depth"""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Determine prefix based on depth
    prefix = "../" * depth if depth > 0 else ""
    
    # Fix logo paths in headers
    content = re.sub(
        r'src="/images/logo/logo\.png"',
        f'src="{prefix}images/logo/logo.png"',
        content
    )
    
    content = re.sub(
        r'src="images/logo/logo\.png"',
        f'src="{prefix}images/logo/logo.png"',
        content
    )
    
    # Fix other /images/ paths in headers (only within header sections)
    content = re.sub(
        r'src="/images/',
        f'src="{prefix}images/',
        content
    )
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Fixed: {file_path}")

# Root directory files (depth 0)
root_files = [
    'contact.html', 'consulting.html', 'equipments.html', 'freezing.html',
    'heating.html', 'pre-process.html', 'product.html', 'service.html',
    'sorting.html', 'spare_parts.html'
]

for file in root_files:
    path = f'f:\\Web\\GBASE\\{file}'
    if os.path.exists(path):
        fix_header_paths(path, 0)

# Subdirectory files (depth 1)
subdirs = {
    'freezing': ['freezing.html', 'spiral.html'],
    'heating': ['filteration.html', 'grill.html', 'oven.html'],
    'process': ['blanching.html', 'cutting.html', 'peeling.html', 'used-equipments.html'],
    'product': ['carton-box-freezer.html', 'contact-freezer.html', 'plate-freezer.html', 'spiral-freezer.html'],
    'sorting': ['sorting.html']
}

for subdir, files in subdirs.items():
    for file in files:
        path = f'f:\\Web\\GBASE\\{subdir}\\{file}'
        if os.path.exists(path):
            fix_header_paths(path, 1)

print("\nDone! All headers fixed.")
