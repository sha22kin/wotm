/**
 * WOTM CMS Admin Panel JavaScript
 * Clean, lightweight, zero-dependency helper functions
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Sidebar Toggle (Desktop Collapse & Mobile Offcanvas Drawer)
  const sidebar = document.getElementById('admSidebar');
  const toggleBtn = document.getElementById('admToggleBtn');
  const closeBtn = document.getElementById('admSidebarClose');
  const backdrop = document.getElementById('admBackdrop');

  function openMobileSidebar() {
    if (sidebar) sidebar.classList.add('is-open');
    document.body.classList.add('adm-open-mobile', 'adm-no-scroll');
  }

  function closeMobileSidebar() {
    if (sidebar) sidebar.classList.remove('is-open');
    document.body.classList.remove('adm-open-mobile', 'adm-no-scroll');
  }

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', function () {
      if (window.innerWidth >= 992) {
        document.body.classList.toggle('adm-collapsed');
        localStorage.setItem('adm_collapsed', document.body.classList.contains('adm-collapsed'));
      } else {
        if (sidebar.classList.contains('is-open')) {
          closeMobileSidebar();
        } else {
          openMobileSidebar();
        }
      }
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeMobileSidebar);
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeMobileSidebar);
  }

  // Close mobile sidebar on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && document.body.classList.contains('adm-open-mobile')) {
      closeMobileSidebar();
    }
  });

  // Submenu Toggle (e.g. Posts -> Categories / All Posts / Add New)
  document.querySelectorAll('.adm-submenu-arrow').forEach(function (arrow) {
    arrow.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const parent = this.closest('.adm-has-submenu');
      if (parent) {
        parent.classList.toggle('is-open');
      }
    });
  });

  // Auto-close mobile sidebar when clicking a nav item on mobile
  if (sidebar) {
    sidebar.querySelectorAll('.adm-nav-link, .adm-submenu-link').forEach(function (link) {
      link.addEventListener('click', function (e) {
        if (e.target.closest('.adm-submenu-arrow')) {
          return;
        }
        if (window.innerWidth < 992) {
          closeMobileSidebar();
        }
      });
    });
  }

  // Restore desktop collapsed state from localStorage
  if (window.innerWidth >= 992 && localStorage.getItem('adm_collapsed') === 'true') {
    document.body.classList.add('adm-collapsed');
  }

  // 2. Dual Language Tabs Switcher
  document.querySelectorAll('.adm-lang-nav').forEach(function (nav) {
    const tabs = nav.querySelectorAll('.adm-lang-tab');
    const container = nav.closest('.adm-card-body') || nav.parentElement;

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        const target = this.getAttribute('data-tab');

        // Toggle tab active state
        tabs.forEach(t => t.classList.remove('is-active'));
        this.classList.add('is-active');

        // Toggle panes
        container.querySelectorAll('.adm-lang-pane').forEach(function (pane) {
          if (pane.getAttribute('data-lang') === target) {
            pane.classList.add('is-active');
          } else {
            pane.classList.remove('is-active');
          }
        });
      });
    });
  });

  // 3. Image Input Live Preview
  document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
    input.addEventListener('change', function () {
      const previewId = this.getAttribute('data-preview');
      const previewEl = document.getElementById(previewId);
      if (previewEl && this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewEl.src = e.target.result;
          previewEl.classList.remove('adm-preview-hidden');
          previewEl.classList.add('adm-preview-shown');
        };
        reader.readAsDataURL(this.files[0]);
      }
    });
  });
});
