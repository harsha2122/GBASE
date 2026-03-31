// Product Card Popover Logic
document.querySelectorAll("[popovertarget]").forEach((btn) => {
  const parent = btn.closest("[popover]");
  if (parent && parent.id !== btn.getAttribute("popovertarget")) {
    btn.addEventListener("click", () => parent.hidePopover());
  }
});

// ================= MOBILE HEADER LOGIC =================
document.addEventListener('DOMContentLoaded', () => {
  const mobileBtn = document.querySelector('.gbase-mobile-menu-btn');
  const drawer = document.querySelector('.gbase-mobile-drawer');
  const overlay = document.querySelector('.gbase-mobile-overlay');
  const closeBtn = document.querySelector('.gbase-mobile-close'); // Custom close inside drawer
  const sidebarCloseBtn = document.querySelector('#menu_sidebar_close_btn'); // Helper close

  // Function to Open Drawer
  function openDrawer() {
    if(drawer) drawer.classList.add('active');
    if(overlay) overlay.classList.add('active');
    document.body.style.overflow = 'hidden'; // Lock scroll
  }

  // Function to Close Drawer
  function closeDrawer() {
    if(drawer) drawer.classList.remove('active');
    if(overlay) overlay.classList.remove('active');
    document.body.style.overflow = ''; // Unlock scroll
  }

  // Event Listeners for Open/Close
  if (mobileBtn) mobileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    openDrawer();
  });
  
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
  if (sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeDrawer);
  if (overlay) overlay.addEventListener('click', closeDrawer);

  // ================= MOBILE DROPDOWNS =================
  // ================= MOBILE DROPDOWNS (Direct Mode) =================
  // Find all dropdown triggers (the span texts or arrows)
  const mobileDropdowns = document.querySelectorAll('.gbase-mobile-dropdown');

  mobileDropdowns.forEach(dropdown => {
    // We target the DIRECT span child of the li to avoid hitting nested spans
    const trigger = dropdown.querySelector(':scope > span');
    
    if (trigger) {
      trigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Stop bubbling
        
        // Toggle the 'open' class on the parent LI
        dropdown.classList.toggle('open');
      });
    }
  });
});

/* ================= MEGA MENU TABS ================= */
document.addEventListener('DOMContentLoaded', function() {
  const tabs = document.querySelectorAll('.gbase-mega-nav .nav-link');
  const panels = document.querySelectorAll('.gbase-mega-tab');

  if(tabs.length > 0) {
      tabs.forEach(tab => {
        tab.addEventListener('mouseover', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('data-target');
          
          // Remove active from all
          tabs.forEach(t => t.classList.remove('active'));
          panels.forEach(p => p.classList.remove('active'));
          
          // Add active to current
          this.classList.add('active');
          const targetPanel = document.getElementById(targetId);
          if (targetPanel) {
            targetPanel.classList.add('active');
          }
        });
      });
  }
});

// Country dropdown: when "Others" is selected, show an open text field.
function syncCountryOtherInput(select) {
  if (!select) return;

  const formGroup = select.closest('.gbase-form-group');
  if (!formGroup) return;

  const otherInput = formGroup.querySelector('.country-other-input');
  if (!otherInput) return;

  const isOthers = (select.value || '').trim().toLowerCase() === 'others';
  otherInput.style.display = isOthers ? 'block' : 'none';
  otherInput.required = isOthers;

  if (!isOthers) {
    otherInput.value = '';
  }
}

document.addEventListener('change', function (e) {
  const select = e.target.closest('select.country-select');
  if (!select) return;
  syncCountryOtherInput(select);
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('select.country-select').forEach(syncCountryOtherInput);
});

// -----------------------------------------------------------------------
// Contact form AJAX submission — handles all .gbase-contact-form forms
// Works from any subdirectory because it uses the absolute /send_mail.php path.
// -----------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('form.gbase-contact-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var btn = form.querySelector('.gbase-submit-btn');
      var originalText = btn ? btn.textContent : '';
      if (btn) { btn.textContent = 'Sending…'; btn.disabled = true; }

      var formData = new FormData(form);

      // Compute path to send_mail.php relative to current page depth
      var depth = window.location.pathname.replace(/\/[^/]*$/, '').split('/').filter(Boolean).length;
      var mailPath = (depth >= 1 ? '../'.repeat(depth) : '') + 'send_mail.php';

      fetch(mailPath, { method: 'POST', body: formData })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          var msgDiv = form.querySelector('.form-response-msg');
          if (!msgDiv) {
            msgDiv = document.createElement('div');
            msgDiv.className = 'form-response-msg';
            msgDiv.style.cssText = 'margin-top:14px;padding:12px 16px;border-radius:6px;font-size:15px;font-weight:500;';
            form.appendChild(msgDiv);
          }
          if (data.success) {
            msgDiv.style.background = '#d4edda';
            msgDiv.style.color = '#155724';
            msgDiv.style.border = '1px solid #c3e6cb';
            msgDiv.textContent = data.message;
            form.reset();
          } else {
            msgDiv.style.background = '#f8d7da';
            msgDiv.style.color = '#721c24';
            msgDiv.style.border = '1px solid #f5c6cb';
            msgDiv.textContent = data.message;
          }
          if (btn) { btn.textContent = originalText; btn.disabled = false; }
        })
        .catch(function () {
          if (btn) { btn.textContent = originalText; btn.disabled = false; }
          alert('Network error. Please check your connection and try again.');
        });
    });
  });
});

// -----------------------------------------------------------------------
// MULTI-SELECT DROPDOWN HANDLING (shared across pages)
// -----------------------------------------------------------------------
function setupMultiSelect() {
  // Open / close dropdowns
  document.querySelectorAll('.multi-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var parent = this.parentElement;

      // close others
      document.querySelectorAll('.multi-wrap.open').forEach(function (wrap) {
        if (wrap !== parent) wrap.classList.remove('open');
      });

      // toggle current
      parent.classList.toggle('open');
    });
  });

  // Keep dropdown open when clicking checkbox; allow native toggle
  document.querySelectorAll('.multi-dropdown input').forEach(function (input) {
    input.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  });

  // Update selected tags for product types and pre-process
  function ensureContainer(afterEl, id) {
    var container = document.getElementById(id);
    if (!container) {
      container = document.createElement('div');
      container.id = id;
      container.className = 'selected-list';
    }
    if (afterEl) {
      if (container.previousElementSibling !== afterEl) {
        afterEl.insertAdjacentElement('afterend', container);
      }
    }
    return container;
  }

  function renderTags(container, values) {
    if (!container) return;
    container.innerHTML = '';
    values.forEach(function (item) {
      container.innerHTML += '<span class="tag">' + item + '</span>';
    });
  }

  function updateProductTags() {
    var selected = [];
    var productDropdown = document.querySelector('.multi-dropdown.w-100');
    var productWrap = productDropdown ? productDropdown.closest('.multi-wrap') : null;
    if (!productWrap) return;
    productWrap.querySelectorAll('input[name="product_types[]"]:checked').forEach(function (cb) {
      selected.push(cb.value);
    });

    var container = ensureContainer(productWrap, 'selected-list');
    renderTags(container, selected);
  }

  function updatePreProcessTags() {
    var selected = [];
    var preProcessDropdown = document.querySelector('.multi-dropdown input[name="pre_process[]"]');
    var preProcessWrap = preProcessDropdown ? preProcessDropdown.closest('.multi-wrap') : null;
    if (!preProcessWrap) return;
    preProcessWrap.querySelectorAll('input[name="pre_process[]"]:checked').forEach(function (cb) {
      selected.push(cb.value);
    });

    var container = ensureContainer(preProcessWrap, 'preprocess-selected-list');
    renderTags(container, selected);
  }

  function updateFreezingTags() {
    var selected = [];
    var freezingInput = document.querySelector('.multi-dropdown input[name="freezing_equipment[]"]');
    var freezingWrap = freezingInput ? freezingInput.closest('.multi-wrap') : null;
    if (!freezingWrap) return;
    freezingWrap.querySelectorAll('input[name="freezing_equipment[]"]:checked').forEach(function (cb) {
      selected.push(cb.value);
    });

    var container = ensureContainer(freezingWrap, 'freezing-selected-list');
    renderTags(container, selected);
  }

  function updateHeatingTags() {
    var selected = [];
    var heatingInput = document.querySelector('.multi-dropdown input[name="heating_equipment[]"]');
    var heatingWrap = heatingInput ? heatingInput.closest('.multi-wrap') : null;
    if (!heatingWrap) return;
    heatingWrap.querySelectorAll('input[name="heating_equipment[]"]:checked').forEach(function (cb) {
      selected.push(cb.value);
    });

    var container = ensureContainer(heatingWrap, 'heating-selected-list');
    renderTags(container, selected);
  }

  function updateSortingTags() {
    var selected = [];
    var sortingInput = document.querySelector('.multi-dropdown input[name="equipment_options[]"]');
    var sortingWrap = sortingInput ? sortingInput.closest('.multi-wrap') : null;
    if (!sortingWrap) return;
    sortingWrap.querySelectorAll('input[name="equipment_options[]"]:checked').forEach(function (cb) {
      selected.push(cb.value);
    });

    var container = ensureContainer(sortingWrap, 'sorting-selected-list');
    renderTags(container, selected);
  }

  document.querySelectorAll('.multi-dropdown input').forEach(function (input) {
    input.addEventListener('change', function () {
      if (input.name === 'product_types[]') updateProductTags();
      if (input.name === 'pre_process[]') updatePreProcessTags();
      if (input.name === 'freezing_equipment[]') updateFreezingTags();
      if (input.name === 'heating_equipment[]') updateHeatingTags();
      if (input.name === 'equipment_options[]') updateSortingTags();
    });
  });

  // Initial render on load
  updateProductTags();
  updatePreProcessTags();
  updateFreezingTags();
  updateHeatingTags();
  updateSortingTags();

  // Close dropdowns on outside click
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.multi-wrap')) {
      document.querySelectorAll('.multi-wrap.open').forEach(function (wrap) {
        wrap.classList.remove('open');
      });
    }
  });

  // Others checkbox toggles (supports multiple ids)
  document.querySelectorAll('input[id$="-others-checkbox"], input#others-checkbox').forEach(function (cb) {
    cb.addEventListener('change', function () {
      var id = cb.id;
      var targetId = id === 'others-checkbox' ? 'others-input' : id.replace('-checkbox', '-input');
      var target = document.getElementById(targetId);
      if (target) {
        target.style.display = cb.checked ? 'block' : 'none';
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', function () {
  setupMultiSelect();
});
