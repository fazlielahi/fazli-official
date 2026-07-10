(function () {
    function scrollProfileNavToActive() {
        var nav = document.querySelector('.profile-shell__nav');
        if (!nav) {
            return;
        }

        var active = nav.querySelector('.profile-nav__link.is-active');
        if (!active) {
            return;
        }

        var navRect = nav.getBoundingClientRect();
        var activeRect = active.getBoundingClientRect();
        var relativeTop = activeRect.top - navRect.top + nav.scrollTop;
        var targetScroll = relativeTop - (nav.clientHeight / 2) + (active.clientHeight / 2);

        nav.scrollTop = Math.max(0, Math.min(targetScroll, nav.scrollHeight - nav.clientHeight));
    }

    function initProfileSidebar() {
        var toggle = document.getElementById('profileSidebarToggle');
        var sidebar = document.getElementById('profileSidebar');

        scrollProfileNavToActive();
        window.addEventListener('load', scrollProfileNavToActive);

        if (toggle && sidebar) {
            toggle.addEventListener('click', function () {
                var open = sidebar.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    requestAnimationFrame(scrollProfileNavToActive);
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProfileSidebar);
    } else {
        initProfileSidebar();
    }
})();
