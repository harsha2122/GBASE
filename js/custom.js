// Product Card Popover Logic
document.querySelectorAll("[popovertarget]").forEach((btn) => {
  const parent = btn.closest("[popover]");
  if (parent && parent.id !== btn.getAttribute("popovertarget")) {
    btn.addEventListener("click", () => parent.hidePopover());
  }
});

// MULTI-SELECT DROPDOWN LOGIC

// 1. Global Click Handler for Toggling and Closing
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.multi-btn');
  const dropdown = e.target.closest('.multi-dropdown');
  const wrap = e.target.closest('.multi-wrap');

  // If clicked on the button
  if (btn) {
    e.preventDefault();
    e.stopPropagation();
    
    // Close other dropdowns
    document.querySelectorAll('.multi-wrap.open').forEach(w => {
      if (w !== wrap) w.classList.remove('open');
    });

    // Toggle current dropdown
    if (wrap) {
      wrap.classList.toggle('open');
    }
    return;
  }

  // If clicked inside the dropdown (inputs, labels, etc.)
  if (dropdown) {
    // Do not close the dropdown.
    // Allow default browser behavior (checkbox toggling).
    return;
  }

  // If clicked anywhere else (outside button and dropdown)
  // Close all open dropdowns
  document.querySelectorAll('.multi-wrap.open').forEach(w => {
    w.classList.remove('open');
  });
});

// 2. Update Selected Tags Display
function updateTags() {
  const selected = [];
  // Collect all checked inputs from all multi-dropdowns
  document.querySelectorAll(".multi-dropdown input:checked").forEach((cb) => {
    selected.push(cb.value);
  });

  const container = document.getElementById("selected-list");
  if (container) {
    container.innerHTML = "";
    selected.forEach((item) => {
      container.innerHTML += `<span class="tag">${item}</span>`;
    });
  }
}

// 3. Listen for changes on inputs using delegation
document.addEventListener('change', function(e) {
  if (e.target.matches('.multi-dropdown input')) {
    updateTags();
  }
});

// Initialize tags on load
document.addEventListener('DOMContentLoaded', () => {
  updateTags();
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
