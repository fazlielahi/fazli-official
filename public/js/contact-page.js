(function () {
    'use strict';

    if (typeof WOW !== 'undefined' && document.querySelector('.wow')) {
        new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true,
        }).init();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('contact-form');
        if (!form || !window.location.search.includes('service=')) {
            return;
        }

        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
})();
