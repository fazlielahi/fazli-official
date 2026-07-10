(function () {
    var banner = document.getElementById('profileWelcomeBanner');
    if (!banner) {
        return;
    }

    var userId = banner.dataset.userId;
    var storageKey = 'tfc_profile_welcome_dismissed_' + userId;
    var toast = document.getElementById('profileWelcomeToast');
    var closeBtn = document.getElementById('profileWelcomeClose');
    var undoBtn = document.getElementById('profileWelcomeUndo');
    var toastCloseBtn = document.getElementById('profileWelcomeToastClose');
    var toastTimer = null;

    function showBanner() {
        banner.hidden = false;
    }

    function hideBanner() {
        banner.hidden = true;
    }

    function hideToast() {
        if (!toast) {
            return;
        }

        toast.classList.remove('is-visible');

        window.setTimeout(function () {
            toast.hidden = true;
        }, 200);

        if (toastTimer) {
            window.clearTimeout(toastTimer);
            toastTimer = null;
        }
    }

    function persistDismiss() {
        try {
            localStorage.setItem(storageKey, '1');
        } catch (error) {
            /* ignore storage errors */
        }
    }

    function clearDismiss() {
        try {
            localStorage.removeItem(storageKey);
        } catch (error) {
            /* ignore storage errors */
        }
    }

    function isDismissed() {
        try {
            return localStorage.getItem(storageKey) === '1';
        } catch (error) {
            return false;
        }
    }

    function finalizeDismiss() {
        hideToast();
        persistDismiss();
    }

    function showToast() {
        if (!toast) {
            persistDismiss();
            return;
        }

        toast.hidden = false;
        window.requestAnimationFrame(function () {
            toast.classList.add('is-visible');
        });

        if (toastTimer) {
            window.clearTimeout(toastTimer);
        }

        toastTimer = window.setTimeout(finalizeDismiss, 2000);
    }

    if (!isDismissed()) {
        showBanner();
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            hideBanner();
            showToast();
        });
    }

    if (undoBtn) {
        undoBtn.addEventListener('click', function () {
            hideToast();
            clearDismiss();
            showBanner();
        });
    }

    if (toastCloseBtn) {
        toastCloseBtn.addEventListener('click', finalizeDismiss);
    }
})();
