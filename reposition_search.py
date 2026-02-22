import os
import re

def remove_old_search(file_path):
    """Remove old search button and modal"""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Remove search button (old position before contact)
    content = re.sub(r'\s*<!-- SEARCH -->\s*\n\s*<button id="gbase-search-btn"[^>]*>.*?</button>\s*\n', '', content, flags=re.DOTALL)
    
    # Remove search overlay modal
    content = re.sub(r'\s*<!-- Search Overlay -->\s*\n.*?<script src="[^"]*js/page-search.js"></script>\s*\n', '', content, flags=re.DOTALL)
    
    # Remove CSS link
    content = re.sub(r'\s*<link rel="stylesheet" href="[^"]*css/search.css" />\s*\n', '', content)
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Cleaned: {file_path}")

def add_search_correctly(file_path, depth):
    """Add search button after Contact button"""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    prefix = "../" * depth if depth > 0 else ""
    
    # 1. Add CSS before </head>
    if 'search.css' not in content:
        css_link = f'    <link rel="stylesheet" href="{prefix}css/search.css" />\n'
        content = content.replace('</head>', css_link + '</head>')
    
    # 2. Add button after Contact </a>
    if 'gbase-search-btn' not in content:
        search_btn = f'''
        <!-- SEARCH -->
        <button id="gbase-search-btn" class="gbase-search-toggle" aria-label="Search">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
'''
        # Match the pattern more carefully
        pattern = r'(Contact <i class="fa-regular fa-arrow-right"[^>]*></i>\s*</a>)'
        if re.search(pattern, content):
            content = re.sub(pattern, r'\1' + search_btn, content)
    
    # 3. Add modal before </body>
    if 'gbase-search-overlay' not in content:
        modal = f'''
    <!-- Search Overlay -->
    <div id="gbase-search-overlay" class="gbase-search-overlay">
      <div class="gbase-search-container">
        <button id="gbase-search-close" class="gbase-search-close" aria-label="Close search">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="gbase-search-header">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input 
            type="text" 
            id="gbase-search-input" 
            placeholder="Search this page..." 
            autocomplete="off"
          />
        </div>
        <div id="gbase-search-results" class="gbase-search-results"></div>
      </div>
    </div>

    <script src="{prefix}js/page-search.js"></script>
'''
        content = content.replace('</body>', modal + '</body>')
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Added search correctly: {file_path}")

# Process all files
root_files = [
    'index.html', 'contact.html', 'consulting.html', 'equipments.html', 
    'freezing.html', 'heating.html', 'pre-process.html', 'product.html', 
    'service.html', 'sorting.html', 'spare_parts.html'
]

for file in root_files:
    path = f'f:\\Web\\GBASE\\{file}'
    if os.path.exists(path):
        remove_old_search(path)
        add_search_correctly(path, 0)

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
            remove_old_search(path)
            add_search_correctly(path, 1)

print("\nDone! Search repositioned on all pages.")
