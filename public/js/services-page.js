(function ($) {
    'use strict';

    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || typeof SplitText === 'undefined') {
        return;
    }

    gsap.registerPlugin(ScrollTrigger, SplitText);

    function titleAnimation() {
        var section = document.querySelector('.sec-title-animation');
        if (!section) {
            return;
        }

        var quotes = section.querySelectorAll('.title-animation');
        if (!quotes.length) {
            return;
        }

        quotes.forEach(function (quote) {
            if (quote.animation) {
                quote.animation.progress(1).kill();
                quote.split.revert();
            }

            var animationClass = section.className.split('animation-')[1];
            if (animationClass === 'style4') {
                return;
            }

            quote.split = new SplitText(quote, {
                type: 'lines,words,chars',
                linesClass: 'split-line',
            });

            gsap.set(quote, { perspective: 400 });

            if (animationClass === 'style1') {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                    y: '90%',
                    rotateX: '-40deg',
                });
            }

            quote.animation = gsap.to(quote.split.chars, {
                scrollTrigger: {
                    trigger: quote,
                    start: 'top 90%',
                },
                x: '0',
                y: '0',
                rotateX: '0',
                opacity: 1,
                duration: 1,
                ease: Back.easeOut,
                stagger: 0.02,
            });
        });
    }

    ScrollTrigger.addEventListener('refresh', titleAnimation);

    $(window).on('load', function () {
        titleAnimation();
    });
})(jQuery);
