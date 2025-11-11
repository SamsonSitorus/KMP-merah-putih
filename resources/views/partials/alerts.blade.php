<!-- Alerts / Toast container -->
<div id="app-alerts" aria-live="polite" aria-atomic="true" style="position:fixed; top:20px; right:20px; z-index:10550; display:flex; flex-direction:column; gap:10px; pointer-events:none;">
  <!-- toasts injected here -->
</div>

<style>
  /* Toast style matching site design (futuristic) */
  .app-toast {
    pointer-events: auto;
    min-width: 280px;
    max-width: 420px;
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(250,250,255,0.9));
    border: 1px solid rgba(3,37,76,0.06);
    border-radius: 12px;
    padding: 12px 14px;
    box-shadow: 0 12px 34px rgba(2,6,23,0.12);
    color: #0f1724;
    display: flex;
    gap: 10px;
    align-items: flex-start;
    transform: translateY(-8px) scale(.98);
    opacity: 0;
    transition: transform 320ms cubic-bezier(.2,.9,.3,1), opacity 300ms ease;
    overflow: hidden;
  }

  .app-toast.show {
    transform: translateY(0) scale(1);
    opacity: 1;
  }

  .app-toast .toast-icon {
    width: 44px; height: 44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex:0 0 44px;
  }

  .app-toast .toast-body { flex:1 1 auto; }
  .app-toast .toast-title { font-weight:700; margin-bottom:4px; font-size:0.95rem; }
  .app-toast .toast-text { font-size:0.87rem; color: #42506b; }

  /* types */
  .app-toast.info { border-left: 4px solid #0077d6; }
  .app-toast.success { border-left: 4px solid #06b6d4; }
  .app-toast.warning { border-left: 4px solid #ffb020; }
  .app-toast.error { border-left: 4px solid #ff4d6d; }

  .app-toast .toast-close { margin-left:8px; background:none; border:none; color:#8b95a6; cursor:pointer; font-size:16px; }

  .app-toast.hide { transform: translateY(-10px) scale(.98); opacity:0; }
</style>

<script>
  window.showAlert = function(message, type = 'info', opts = {}) {
    try {
      const container = document.getElementById('app-alerts');
      if (!container) return alert(message);

      const toast = document.createElement('div');
      toast.className = `app-toast ${type}`;
      toast.innerHTML = `\
        <div class="toast-icon">${getIconFor(type)}</div>\
        <div class="toast-body">\
          <div class="toast-title">${escapeHtml(opts.title || (type==='success'?'Sukses': (type==='error'?'Error':'Informasi')))}</div>\
          <div class="toast-text">${escapeHtml(message)}</div>\
        </div>\
        <button class="toast-close" aria-label="Close">&times;</button>`;

      container.prepend(toast);
      requestAnimationFrame(() => toast.classList.add('show'));

      const closeBtn = toast.querySelector('.toast-close');
      closeBtn.addEventListener('click', () => removeToast(toast));

      const duration = opts.duration || (type==='error' ? 6000 : 4200);
      let timer = setTimeout(() => removeToast(toast), duration);

      toast.addEventListener('mouseenter', () => clearTimeout(timer));
      toast.addEventListener('mouseleave', () => { timer = setTimeout(() => removeToast(toast), 2000); });

      function removeToast(t) {
        t.classList.remove('show');
        t.classList.add('hide');
        setTimeout(() => { try { t.remove(); } catch(e){} }, 340);
      }

      function getIconFor(t) {
        if (t === 'success') return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
        if (t === 'error') return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="#ff4d6d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
        if (t === 'warning') return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94A2 2 0 0 0 23 18L14.71 3.86a2 2 0 0 0-3.42 0z" stroke="#ffb020" stroke-width="1.2" fill="rgba(255,176,32,0.08)"/></svg>`;
        return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#0077d6" stroke-width="1.8"/><path d="M12 8v4l2 2" stroke="#0077d6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
      }

      function escapeHtml(str){ return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    } catch(err){ console.error('showAlert error', err); alert(message); }
  }
</script>
