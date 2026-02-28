/* ============================================================
   Laravel Notes – app.js
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Lucide icons init ─────────────────────────────────── */
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }

  /* ── Mobile nav toggle ─────────────────────────────────── */
  const hamburger = document.querySelector('.nav-hamburger');
  const navLinks  = document.querySelector('header nav > div:nth-child(2)');
  const navUser   = document.querySelector('header nav > div:last-child');

  if (hamburger) {
    hamburger.addEventListener('click', () => {
      navLinks?.classList.toggle('open');
      navUser?.classList.toggle('open');
      const icon = hamburger.querySelector('i');
      if (icon) {
        const isOpen = navLinks?.classList.contains('open');
        icon.setAttribute('data-lucide', isOpen ? 'x' : 'menu');
        lucide.createIcons();
      }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!e.target.closest('header')) {
        navLinks?.classList.remove('open');
        navUser?.classList.remove('open');
        const icon = hamburger.querySelector('i');
        if (icon) {
          icon.setAttribute('data-lucide', 'menu');
          lucide.createIcons();
        }
      }
    });
  }

  /* ── Alert dismiss ──────────────────────────────────────── */
  document.querySelectorAll('.alert-close').forEach(btn => {
    btn.addEventListener('click', () => {
      const alert = btn.closest('.alert');
      if (alert) {
        alert.style.transition = 'opacity 180ms ease, transform 180ms ease, max-height 220ms ease, margin 220ms ease, padding 220ms ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-4px)';
        setTimeout(() => alert.remove(), 220);
      }
    });
  });

  /* ── Auto-dismiss success alerts after 5s ──────────────── */
  document.querySelectorAll('.alert-success').forEach(alert => {
    setTimeout(() => {
      if (!alert.isConnected) return;
      alert.style.transition = 'opacity 400ms ease, transform 400ms ease';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-4px)';
      setTimeout(() => alert.remove(), 400);
    }, 5000);
  });

  /* ── Modal system ───────────────────────────────────────── */
  // Open: data-modal-open="modal-id"
  // Close: data-modal-close or .modal-overlay click
  document.querySelectorAll('[data-modal-open]').forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const id = trigger.dataset.modalOpen;
      const modal = document.getElementById(id);
      if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
      }
    });
  });

  function closeModal(modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal-overlay');
      if (modal) closeModal(modal);
    });
  });

  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) closeModal(overlay);
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-overlay.open').forEach(closeModal);
    }
  });

  /* ── Confirm-delete shorthand ───────────────────────────── */
  // Add data-confirm="Are you sure?" to any button/link
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', (e) => {
      const msg = el.dataset.confirm || 'Are you sure?';
      if (!confirm(msg)) e.preventDefault();
    });
  });

  /* ── Active nav link highlight ──────────────────────────── */
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (currentPath === href || currentPath.startsWith(href + '/') && href !== '/')) {
      link.classList.add('active');
    }
  });

  /* ── Flash message from URL hash ───────────────────────── */
  // e.g. redirect back with #success=Saved!
  // (optional convenience — noop if not used)

});

// ── Note create/edit: notable_type → notable_id sync ───────
document.addEventListener('DOMContentLoaded', () => {
  const notableTypeSelect = document.getElementById('notable_type');
  const notableIdInput    = document.getElementById('notable_id');

  if (notableTypeSelect && notableIdInput) {
    notableTypeSelect.addEventListener('change', function () {
      const selected = this.selectedOptions[0];
      notableIdInput.value = selected.dataset.id || notableIdInput.dataset.userId || '';
    });
  }
});

// ── Icon Picker ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-icon-picker]').forEach(wrap => {
    const hiddenInput   = wrap.querySelector('input[type="hidden"]');
    const searchInput   = wrap.querySelector('.icon-picker-search');
    const grid          = wrap.querySelector('.icon-picker-grid');
    const selectedWrap  = wrap.querySelector('.icon-picker-selected');
    const selectedIcon  = wrap.querySelector('.icon-picker-selected-preview i');
    const selectedName  = wrap.querySelector('.icon-picker-selected-name');
    const clearBtn      = wrap.querySelector('.icon-picker-clear');
    const countEl       = wrap.querySelector('.ip-count');

    if (!grid || !hiddenInput) return;

    const allBtns = () => Array.from(grid.querySelectorAll('.icon-btn'));

    function setSelected(slug) {
      hiddenInput.value = slug || '';
      if (slug) {
        selectedWrap.style.display = 'flex';
        selectedName.textContent = slug;
        if (selectedIcon) {
          selectedIcon.setAttribute('data-lucide', slug);
          lucide.createIcons({ nodes: [selectedIcon] });
        }
        allBtns().forEach(b => b.classList.toggle('selected', b.dataset.icon === slug));
      } else {
        selectedWrap.style.display = 'none';
        allBtns().forEach(b => b.classList.remove('selected'));
      }
    }

    // Init
    setSelected(hiddenInput.value || '');

    // Click icon
    grid.addEventListener('click', e => {
      const btn = e.target.closest('.icon-btn');
      if (!btn) return;
      const slug = btn.dataset.icon;
      setSelected(hiddenInput.value === slug ? '' : slug);
    });

    // Clear
    clearBtn?.addEventListener('click', () => setSelected(''));

    // Search filter
    searchInput?.addEventListener('input', () => {
      const q = searchInput.value.toLowerCase().trim();
      let visible = 0;
      allBtns().forEach(btn => {
        const match = !q || btn.dataset.icon.includes(q);
        btn.style.display = match ? '' : 'none';
        if (match) visible++;
      });
      if (countEl) countEl.textContent = `${visible} icons`;
      // no-results placeholder
      let noRes = grid.querySelector('.icon-picker-no-results');
      if (visible === 0) {
        if (!noRes) {
          noRes = document.createElement('div');
          noRes.className = 'icon-picker-no-results';
          noRes.textContent = 'No icons match "' + q + '"';
          grid.appendChild(noRes);
        } else {
          noRes.textContent = 'No icons match "' + q + '"';
          noRes.style.display = '';
        }
      } else if (noRes) {
        noRes.style.display = 'none';
      }
    });
  });
});