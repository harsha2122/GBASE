"""
update_form_names.py
Adds name attributes to all .gbase-contact-form fields across all HTML files,
and inserts a hidden page_source input to identify which page the enquiry came from.
"""

import os
import re
from bs4 import BeautifulSoup, NavigableString, Tag

# -------------------------------------------------------------------
# Helpers
# -------------------------------------------------------------------

def get_label_text(el):
    """
    Return clean lowercase text from a <label> element (strips inner <span> etc.).
    """
    texts = []
    for content in el.contents:
        if isinstance(content, NavigableString):
            texts.append(str(content))
        elif isinstance(content, Tag) and content.name != 'span':
            texts.append(content.get_text())
    return ' '.join(texts).strip().lower()


def label_to_field_name(label_text):
    """
    Map a label's text to a POST field name.
    Returns None if we can't confidently determine the name.
    """
    t = label_text.lower().strip()
    mapping = [
        ('company',           'company'),
        ('name',              'name'),
        ('city',              'city'),
        ('email',             'email'),
        ('phone',             'phone'),
        ('website',           'website'),
        ('products',          'products'),
        ('cut size',          'cut_sizes'),
        ('capacit',           'capacities'),
        ('estimated produc',  'production'),
        ('type of business',  'business_type'),
        ('others (specify)',  'others_specify'),
        ('type in your need', 'message'),
        ('type of product',   'product_type'),   # single select
        ('equipment of int',  'equipment_interest'),
        ('equipment of inter','equipment_interest'),
        ('how did you find',  'referral'),
        ('type of business',  'business_type'),
        ('country',           'country'),
    ]
    for key, field_name in mapping:
        if key in t:
            return field_name
    return None


def placeholder_to_field_name(placeholder):
    """
    Map a placeholder string to a POST field name.
    """
    p = placeholder.lower().strip().rstrip(' *')
    mapping = [
        ('company',              'company'),
        ('name',                 'name'),
        ('city',                 'city'),
        ('email',                'email'),
        ('phone',                'phone'),
        ('website',              'website'),
        ('type in your need',    'message'),
        ('please specify country','country_other'),
        ('estimated produc',     'production'),
        ('products',             'products'),
        ('cut size',             'cut_sizes'),
        ('capacit',              'capacities'),
    ]
    for key, field_name in mapping:
        if key in p:
            return field_name
    return None


def get_multi_wrap_name(multi_wrap):
    """
    Determine the checkbox name[] for a .multi-wrap based on context:
    - Look at the preceding sibling label in the parent div
    - Or look at the button text inside the multi-wrap
    """
    # Check the button text first (most reliable for heating/freezing/pre-process)
    btn = multi_wrap.find('button', class_='multi-btn')
    btn_text = (btn.get_text(strip=True) if btn else '').lower()

    if 'heating' in btn_text:
        return 'heating_equipment[]'
    if 'freezing' in btn_text or 'iqf' in btn_text:
        return 'freezing_equipment[]'
    if 'cutting' in btn_text or 'dicing' in btn_text or 'pre' in btn_text or 'options' in btn_text or 'processing' in btn_text:
        return 'pre_process[]'
    if 'select' in btn_text:
        # This is the product types multi-select; confirm via parent label
        parent = multi_wrap.parent
        if parent:
            for sib in parent.children:
                if isinstance(sib, Tag) and sib.name == 'label':
                    lbl = sib.get_text(strip=True).lower()
                    if 'product' in lbl:
                        return 'product_types[]'
        return 'product_types[]'

    # Fallback: look at preceding label in parent
    parent = multi_wrap.parent
    if parent:
        prev = multi_wrap.find_previous_sibling('label')
        if prev:
            lbl = prev.get_text(strip=True).lower()
            if 'product' in lbl:
                return 'product_types[]'
            if 'pre' in lbl or 'process' in lbl:
                return 'pre_process[]'
            if 'heat' in lbl:
                return 'heating_equipment[]'
            if 'freez' in lbl:
                return 'freezing_equipment[]'

    return 'equipment_options[]'


def derive_name_for_input(inp, form):
    """
    Return the appropriate name for an input/select/textarea tag.
    Returns None if it should be left alone.
    """
    tag = inp.name  # 'input', 'select', 'textarea'
    classes = inp.get('class', [])
    itype = inp.get('type', 'text').lower() if tag == 'input' else tag

    # Already has name? skip
    if inp.get('name'):
        return None

    # By type
    if itype == 'email':
        return 'email'
    if itype == 'tel':
        return 'phone'
    if itype == 'url':
        return 'website'
    if itype == 'hidden':
        return None  # don't touch

    # Country-specific classes
    if 'country-select' in classes:
        return 'country'
    if 'country-other-input' in classes:
        return 'country_other'

    # Textarea
    if tag == 'textarea':
        return 'message'

    # Checkboxes inside multi-wrap
    if itype == 'checkbox':
        multi_wrap = inp.find_parent(class_='multi-wrap')
        if multi_wrap:
            return get_multi_wrap_name(multi_wrap)
        return None  # standalone checkbox, leave alone

    # Text inputs and selects — look at placeholder then adjacent label
    placeholder = inp.get('placeholder', '')
    if placeholder:
        name = placeholder_to_field_name(placeholder)
        if name:
            return name

    # For <select>: check the first <option> if it's a disabled placeholder
    if tag == 'select':
        first_opt = inp.find('option')
        if first_opt and first_opt.get('disabled') is not None:
            opt_text = first_opt.get_text(strip=True)
            name = label_to_field_name(opt_text.lower())
            if name:
                return name

    # html.parser quirk: for void elements (<input>), it may nest sibling <label>
    # as a child of the input rather than a sibling. Check children first.
    child_label = inp.find('label')
    if child_label:
        name = label_to_field_name(get_label_text(child_label))
        if name:
            return name

    # Look for a sibling label (label comes AFTER input in Pattern B forms)
    parent = inp.parent
    if parent:
        # Check direct sibling label
        next_sib = inp.find_next_sibling('label')
        if next_sib:
            name = label_to_field_name(get_label_text(next_sib))
            if name:
                return name
        # Check label in parent's parent (for select wrapped in extra div)
        prev_sib = inp.find_previous_sibling('label')
        if prev_sib:
            name = label_to_field_name(get_label_text(prev_sib))
            if name:
                return name

    return None


# -------------------------------------------------------------------
# Main
# -------------------------------------------------------------------

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    soup = BeautifulSoup(content, 'html.parser')
    contact_forms = soup.find_all('form', class_='gbase-contact-form')

    if not contact_forms:
        return False  # nothing to do

    changed = False

    for form in contact_forms:
        # --- Add hidden page_source if not already present ---
        if not form.find('input', {'name': 'page_source'}):
            rel_path = os.path.relpath(filepath, '/home/user/GBASE')
            hidden = soup.new_tag('input', type='hidden', attrs={
                'name': 'page_source',
                'value': rel_path
            })
            # Insert as first child inside the form > div.row
            row_div = form.find('div', class_='row')
            if row_div:
                row_div.insert(0, hidden)
            else:
                form.insert(0, hidden)
            changed = True

        # --- Add name attributes to all fields ---
        fields = form.find_all(['input', 'select', 'textarea'])
        for field in fields:
            if field.get('name'):
                continue  # already named
            name = derive_name_for_input(field, form)
            if name:
                field['name'] = name
                changed = True

    if not changed:
        return False

    # Write back
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(str(soup))

    return True


def find_html_files(root):
    html_files = []
    for dirpath, dirnames, filenames in os.walk(root):
        # Skip hidden dirs and git internals
        dirnames[:] = [d for d in dirnames if not d.startswith('.')]
        for fname in filenames:
            if fname.endswith('.html'):
                html_files.append(os.path.join(dirpath, fname))
    return html_files


if __name__ == '__main__':
    root = '/home/user/GBASE'
    files = find_html_files(root)
    updated = 0
    skipped = 0
    for fpath in sorted(files):
        if process_file(fpath):
            print(f'  [UPDATED] {os.path.relpath(fpath, root)}')
            updated += 1
        else:
            skipped += 1

    print(f'\nDone. {updated} file(s) updated, {skipped} file(s) skipped (no gbase-contact-form).')
