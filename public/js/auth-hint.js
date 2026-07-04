(function () {
  var cfg = window.TFC_AUTH_HINT || {};
  var loginBase = cfg.loginUrl || '';
  var overlayEl = null;
  var toastEl = null;
  var hideTimer = null;

  function buildLoginUrl(nextUrl) {
    if (!loginBase) {
      return nextUrl || '#';
    }

    try {
      var url = new URL(loginBase, window.location.origin);
      if (nextUrl) {
        url.searchParams.set('next', nextUrl);
      }
      return url.toString();
    } catch (e) {
      return loginBase;
    }
  }

  function ensureOverlay() {
    if (!overlayEl) {
      overlayEl = document.getElementById('auth-required-overlay');
      toastEl = document.getElementById('auth-required-toast');
    }
    return overlayEl;
  }

  function hideToast() {
    var overlay = ensureOverlay();
    if (!overlay) {
      return;
    }

    overlay.hidden = true;
    overlay.setAttribute('aria-hidden', 'true');
    overlay.classList.remove('is-visible');
    document.body.classList.remove('auth-required-open');

    if (hideTimer) {
      clearTimeout(hideTimer);
      hideTimer = null;
    }
  }

  function showToast(nextUrl) {
    var overlay = ensureOverlay();
    if (!overlay) {
      return;
    }

    var loginLink = overlay.querySelector('[data-auth-login]');
    if (loginLink) {
      loginLink.href = buildLoginUrl(nextUrl);
    }

    overlay.hidden = false;
    overlay.setAttribute('aria-hidden', 'false');
    overlay.classList.add('is-visible');
    document.body.classList.add('auth-required-open');

    if (hideTimer) {
      clearTimeout(hideTimer);
    }

    hideTimer = setTimeout(hideToast, 12000);
  }

  document.addEventListener('click', function (event) {
    var trigger = event.target.closest('[data-requires-auth]');
    if (!trigger) {
      return;
    }

    event.preventDefault();

    var next = trigger.getAttribute('data-auth-next') || trigger.getAttribute('href') || '';
    showToast(next);
  });

  document.addEventListener('click', function (event) {
    if (event.target.closest('[data-auth-dismiss]')) {
      event.preventDefault();
      hideToast();
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      hideToast();
    }
  });
})();
