/* ============================================================
   Laravel Notes – app.js
   ============================================================ */

/* ── Lucide helper ─────────────────────────────────────────────
   Lucide replaces <i data-lucide="x"> with an <svg>, so after
   first render the <i> is gone. To re-render into a container,
   rebuild the <i> inside its wrapper then call
   lucide.createIcons({ el: container }).
   ─────────────────────────────────────────────────────────── */
function lucideInto(container, iconName, size = '15px') {
  if (!container || !iconName) return;
  container.innerHTML = `<i data-lucide="${iconName}" style="width:${size};height:${size};display:block;"></i>`;
  if (typeof lucide !== 'undefined') lucide.createIcons({ el: container });
}

document.addEventListener('DOMContentLoaded', () => {

  /* ── Init all Lucide icons ──────────────────────────────── */
  if (typeof lucide !== 'undefined') lucide.createIcons();

  /* ── Active nav highlighting ────────────────────────────── */
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (!href || href === '#') return;
    const isActive = currentPath === href ||
      (href.length > 1 && currentPath.startsWith(href + '/')) ||
      (href.length > 1 && currentPath === href);
    if (isActive) link.classList.add('active');
  });

  /* ── Mobile hamburger (compact top-bar on mid screens) ─── */
  const hamburger = document.querySelector('.nav-hamburger');
  const topLinks   = document.querySelector('.nav-top-links');
  const navRight   = document.querySelector('.nav-right');

  if (hamburger) {
    hamburger.addEventListener('click', () => {
      const isOpen = topLinks?.classList.toggle('open');
      navRight?.classList.toggle('open', isOpen);
      const iconSpan = hamburger.querySelector('.nav-ham-icon');
      if (iconSpan) lucideInto(iconSpan, isOpen ? 'x' : 'menu', '20px');
    });
    document.addEventListener('click', (e) => {
      if (!e.target.closest('header')) {
        topLinks?.classList.remove('open');
        navRight?.classList.remove('open');
        const iconSpan = hamburger.querySelector('.nav-ham-icon');
        if (iconSpan) lucideInto(iconSpan, 'menu', '20px');
      }
    });
  }

  /* ── Alert dismiss ──────────────────────────────────────── */
  document.querySelectorAll('.alert-close').forEach(btn => {
    btn.addEventListener('click', () => {
      const alert = btn.closest('.alert');
      if (!alert) return;
      alert.style.transition = 'opacity 180ms ease, transform 180ms ease';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-4px)';
      setTimeout(() => alert.remove(), 200);
    });
  });

  document.querySelectorAll('.alert-success').forEach(alert => {
    setTimeout(() => {
      if (!alert.isConnected) return;
      alert.style.transition = 'opacity 400ms ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 400);
    }, 5000);
  });

  /* ── Modal system ───────────────────────────────────────── */
  function closeModal(modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('[data-modal-open]').forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const modal = document.getElementById(trigger.dataset.modalOpen);
      if (modal) { modal.classList.add('open'); document.body.style.overflow = 'hidden'; }
    });
  });

  document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal-overlay');
      if (modal) closeModal(modal);
    });
  });

  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(overlay); });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(closeModal);
  });

  /* ── data-confirm shorthand ─────────────────────────────── */
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', (e) => {
      if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
  });

  /* ── Notebook select (custom dropdown) ──────────────────── */
  document.querySelectorAll('[data-nb-select]').forEach(wrap => {
    const trigger    = wrap.querySelector('.nb-select-trigger');
    const dropdown   = wrap.querySelector('.nb-select-dropdown');
    const options    = wrap.querySelectorAll('.nb-select-option');
    const hiddenType = wrap.querySelector('input[name="notable_type"]');
    const hiddenId   = wrap.querySelector('input[name="notable_id"]');

    if (!trigger || !dropdown) return;

    /* Toggle open */
    trigger.addEventListener('click', e => {
      e.stopPropagation();
      const isOpen = wrap.classList.contains('open');
      document.querySelectorAll('[data-nb-select].open').forEach(w => w.classList.remove('open'));
      if (!isOpen) wrap.classList.add('open');
    });

    /* Select an option */
    options.forEach(opt => {
      opt.addEventListener('click', () => {
        /* 1 – hidden inputs */
        hiddenType.value = opt.dataset.notableType;
        hiddenId.value   = opt.dataset.notableId;

        /* 2 – rebuild icon in trigger (SVG was already rendered, <i> is gone) */
        const iconContainer = trigger.querySelector('.nb-select-icon');
        const isPersonal    = opt.dataset.personal === '1';
        iconContainer.className = 'nb-select-icon' + (isPersonal ? ' personal' : '');
        lucideInto(iconContainer, opt.dataset.icon || 'book-open', '15px');

        /* 3 – update text */
        trigger.querySelector('.nb-select-label').textContent = opt.dataset.label;
        const count = opt.dataset.count;
        trigger.querySelector('.nb-select-sublabel').textContent =
          isPersonal ? 'Personal' : (count + ' ' + (count === '1' ? 'note' : 'notes'));

        /* 4 – mark selected */
        options.forEach(o => o.classList.remove('selected'));
        opt.classList.add('selected');

        wrap.classList.remove('open');
      });
    });

    document.addEventListener('click', e => {
      if (!wrap.contains(e.target)) wrap.classList.remove('open');
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') wrap.classList.remove('open');
    });
  });

  /* ── Icon Picker ─────────────────────────────────────────── */
  document.querySelectorAll('[data-icon-picker]').forEach(wrap => {
    const hiddenInput  = wrap.querySelector('input[type="hidden"]');
    const searchInput  = wrap.querySelector('.icon-picker-search');
    const grid         = wrap.querySelector('.icon-picker-grid');
    const selectedWrap = wrap.querySelector('.icon-picker-selected');
    const selectedPrev = wrap.querySelector('.icon-picker-selected-preview');
    const selectedName = wrap.querySelector('.icon-picker-selected-name');
    const clearBtn     = wrap.querySelector('.icon-picker-clear');
    const countEl      = wrap.querySelector('.ip-count');

    if (!grid || !hiddenInput) return;

    const allBtns = () => Array.from(grid.querySelectorAll('.icon-btn'));

    function setSelected(slug) {
      hiddenInput.value = slug || '';
      if (slug) {
        selectedWrap.style.display = 'flex';
        selectedName.textContent   = slug;
        /* Rebuild icon inside preview container */
        lucideInto(selectedPrev, slug, '14px');
        allBtns().forEach(b => b.classList.toggle('selected', b.dataset.icon === slug));
      } else {
        selectedWrap.style.display = 'none';
        allBtns().forEach(b => b.classList.remove('selected'));
      }
    }

    setSelected(hiddenInput.value || '');

    grid.addEventListener('click', e => {
      const btn = e.target.closest('.icon-btn');
      if (!btn) return;
      setSelected(hiddenInput.value === btn.dataset.icon ? '' : btn.dataset.icon);
    });

    clearBtn?.addEventListener('click', () => setSelected(''));

    searchInput?.addEventListener('input', () => {
      const q = searchInput.value.toLowerCase().trim();
      let visible = 0;
      allBtns().forEach(btn => {
        const match = !q || btn.dataset.icon.includes(q);
        btn.style.display = match ? '' : 'none';
        if (match) visible++;
      });
      if (countEl) countEl.textContent = `${visible} icons`;
      let noRes = grid.querySelector('.icon-picker-no-results');
      if (visible === 0) {
        if (!noRes) { noRes = document.createElement('div'); noRes.className = 'icon-picker-no-results'; grid.appendChild(noRes); }
        noRes.textContent   = `No icons match "${q}"`;
        noRes.style.display = '';
      } else if (noRes) { noRes.style.display = 'none'; }
    });
  });

});

// ── Password visibility toggle ─────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.input-wrap').querySelector('input');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      lucideInto(btn, isHidden ? 'eye-off' : 'eye', '16px');
    });
  });
});