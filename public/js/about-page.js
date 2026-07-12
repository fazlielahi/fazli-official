(function ($) {
    'use strict';

    var isRtl = document.documentElement.getAttribute('dir') === 'rtl';

    var owlDefaults = {
        loop: true,
        margin: 16,
        nav: true,
        dots: true,
        smartSpeed: 500,
        autoplay: true,
        autoplayTimeout: 7000,
        rtl: isRtl,
        navText: [
            '<span class="icon-arrow-left-up"></span>',
            '<span class="icon-arrow-up-right-2"></span>',
        ],
    };

    function buildOwlOptions(responsive) {
        return $.extend(true, {}, owlDefaults, {
            responsive: responsive,
        });
    }

    function initCarousels() {
        if ($('.blogs-one__carousel').length) {
            $('.blogs-one__carousel').owlCarousel(buildOwlOptions({
                0: { items: 1 },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            }));
        }

        if ($('.blog-one__carousel').length) {
            $('.blog-one__carousel').owlCarousel(buildOwlOptions({
                0: { items: 1 },
                768: { items: 2 },
                992: { items: 3 },
                1200: { items: 3 },
                1320: { items: 3 },
            }));
        }

        if ($('.testimonial-one__carousel').length) {
            $('.testimonial-one__carousel').owlCarousel(buildOwlOptions({
                0: { items: 1 },
                768: { items: 1 },
                992: { items: 1 },
                1200: { items: 1 },
                1320: { items: 1 },
            }));
        }
    }

    function refreshRtlCarousels() {
        if (!isRtl) {
            return;
        }

        $('.blogs-one__carousel, .blog-one__carousel, .testimonial-one__carousel').each(function () {
            var $carousel = $(this);

            if ($carousel.hasClass('owl-loaded')) {
                $carousel.trigger('refresh.owl.carousel');
            }
        });
    }

    function initOdometer() {
        if (!$('.odometer').length) {
            return;
        }

        $('.odometer').each(function () {
            var $counter = $(this);
            $counter.appear(function () {
                $counter.html($counter.attr('data-count'));
            });
        });
    }

    function initWow() {
        if (typeof WOW === 'undefined' || !$('.wow').length) {
            return;
        }

        new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            mobile: true,
            live: true,
        }).init();
    }

    function initHeartToggle() {
        $('.blogs-one__heart-btn').on('click', function (event) {
            event.preventDefault();
            var $heartIcon = $(this).find('.icon-heart');
            $heartIcon.toggleClass('active');

            if ($heartIcon.hasClass('active')) {
                $heartIcon.addClass('heart-beat');
                window.setTimeout(function () {
                    $heartIcon.removeClass('heart-beat');
                }, 300);
            }
        });
    }

    function updateScrollToTop() {
        var $progress = $('.scroll-to-top .scroll-to-top__inner');
        if ($progress.length) {
            var bodyHeight = $('body').height();
            var scrollPos = $(window).innerHeight() + $(window).scrollTop();
            var percentage = Math.min((scrollPos / bodyHeight) * 100, 100);
            $progress.css('width', percentage + '%');
        }

        var $button = $('.scroll-to-top');
        if ($button.length) {
            $button.toggleClass('show', $(window).scrollTop() > 500);
        }
    }

    function initTitleAnimation() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || typeof SplitText === 'undefined') {
            return;
        }

        gsap.registerPlugin(ScrollTrigger, SplitText);

        document.querySelectorAll('.sec-title-animation .title-animation').forEach(function (quote) {
            if (quote.animation) {
                quote.animation.progress(1).kill();
                quote.split.revert();
            }

            var sectionClass = quote.closest('.sec-title-animation').className;
            var animation = sectionClass.split('animation-');
            if (animation[1] === 'style4') {
                return;
            }

            quote.split = new SplitText(quote, {
                type: 'lines,words,chars',
                linesClass: 'split-line',
            });

            gsap.set(quote, { perspective: 400 });

            if (animation[1] === 'style1') {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                    y: '90%',
                    rotateX: '-40deg',
                });
            }

            if (animation[1] === 'style2') {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                    x: '50',
                });
            }

            if (animation[1] === 'style3') {
                gsap.set(quote.split.chars, {
                    opacity: 0,
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

    function initCvPreviewModal() {
        var $modal = $('#about-cv-preview-modal');
        if (!$modal.length) {
            return;
        }

        $modal.on('show.bs.modal', function (event) {
            var $button = $(event.relatedTarget);
            var previewImage = $button.data('preview-image');
            var templateName = $button.data('template-name');
            var templateSlug = $button.data('template-slug');
            var $self = $(this);

            $self.find('#aboutCvPreviewModalLabel').text(templateName + ' - Preview');
            $self.find('#aboutCvPreviewModalImage').attr({
                src: previewImage,
                alt: templateName + ' Preview',
            });

            var useUrl = $self.data('builder-url').replace('TEMPLATE_SLUG', templateSlug);
            $self.find('#aboutCvPreviewModalUseBtn').attr('href', useUrl);
        });

        $('#aboutCvPreviewModalImage').on('error', function () {
            var $img = $(this);
            if ($img.siblings('.image-error-message').length === 0) {
                $img.after('<p class="text-muted mt-3 image-error-message">Preview image could not be loaded</p>');
            }
        });

        $modal.on('hidden.bs.modal', function () {
            $(this).find('.image-error-message').remove();
        });
    }

    $(function () {
        initCarousels();
        initOdometer();
        initHeartToggle();
        updateScrollToTop();
        initCvPreviewModal();
    });

    $(window).on('load', function () {
        initWow();
        initTitleAnimation();
        refreshRtlCarousels();
    });

    $(window).on('scroll', updateScrollToTop);
})(jQuery);
