import os
import re

def add_search_to_html(file_path, depth):
    """Add search button and modal to HTML file"""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Skip if search already added
    if 'gbase-search-btn' in content:
        print(f"Skipped (already has search): {file_path}")
        return
    
    prefix = "../" * depth if depth > 0 else ""
    
    # 1. Add CSS link before </head>
    css_link = f'    <link rel="stylesheet" href="{prefix}css/search.css" />\n'
    if '</head>' in content:
        content = content.replace('</head>', css_link + '</head>')
    
    # 2. Add search button after Contact button in header
    search_btn = '''
        <!-- SEARCH -->
        <button id="gbase-search-btn" class="gbase-search-toggle" aria-label="Search">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
'''
    
    # Find the Contact button and insert search after it
    contact_pattern = r'(</a>\s*\n\s*</div>\s*\n\s*</header>)'
    if re.search(contact_pattern, content):
        content = re.sub(contact_pattern, r'</a>' + search_btn + r'\n\n      </div>\n    </header>', content)
    
    # 3. Add search modal before closing </body>
    search_modal = '''
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

    <script src="''' + prefix + '''js/page-search.js"></script>
'''
    
    if '</body>' in content:
        content = content.replace('</body>', search_modal + '</body>')
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Added search to: {file_path}")

# Root directory files (depth 0)
root_files = [
    'index.html', 'contact.html', 'consulting.html', 'equipments.html', 
    'freezing.html', 'heating.html', 'pre-process.html', 'product.html', 
    'service.html', 'sorting.html', 'spare_parts.html'
]

for file in root_files:
    path = f'f:\\Web\\GBASE\\{file}'
    if os.path.exists(path):
        add_search_to_html(path, 0)

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
            add_search_to_html(path, 1)

print("\nDone! Search added to all pages.")
