(function($) {
  $.fn.marqueeSlider = function(options) {
    const defaults = {
      sensitivity: 0.1,
      repeatItems: true,
    };

    return this.each(function(index, element) {
      const container = $(element);
      const lists = container.find('.marquee-slider__list');
      const settings = $.extend({}, defaults, options[index]);

      // Store list data and clone items
      const listData = [];
      if (settings.repeatItems) {
        lists.each(function() {
          const list = $(this);
          const items = list.find('.marquee-slider__list--item').not('.cloned');
          let width = 0;
          items.each(function() {
            width += $(this).outerWidth(true);
          });
          listData.push({ width: width });
          // Clone items for seamless loop
          items.clone().addClass('cloned').appendTo(list);
          items.clone().addClass('cloned').appendTo(list);
        });
      }

      // Position tracking
      const positions = [];
      lists.each(function() {
        positions.push(0);
      });

      let lastScrollTop = 0;
      let manualTimeout = null;
      let isManual = false;

      // Update slider position
      function updatePosition() {
        lists.each(function(index) {
          const direction = index % 2 === 0 ? -1 : 1;
          const data = listData[index];
          
          if (data && settings.repeatItems) {
            const speed = 3;
            let translate = positions[index] * direction * speed;
            const width = data.width;
            
            // Wrap around for infinite loop
            translate = ((translate % width) + width) % width;
            if (direction < 0 && translate > 0) {
              translate = translate - width;
            }
            
            $(this).css('transform', `translate3d(${translate}px, 0, 0)`);
          } else {
            $(this).css('transform', `translate3d(${positions[index] * direction}%, 0, 0)`);
          }
        });
      }

      // Handle scroll
      function handleScroll() {
        if (isManual) return;
        
        const st = $(window).scrollTop();
        const speed = 3;

        lists.each(function(index) {
          if (st > lastScrollTop) {
            positions[index] += settings.sensitivity;
          } else {
            positions[index] -= settings.sensitivity;
          }
        });

        updatePosition();
        lastScrollTop = st;
      }

      // Manual navigation
      function navigate(direction) {
        isManual = true;
        const step = 100;
        const speed = 3;
        
        lists.each(function(index) {
          // Convert pixel step to position units
          positions[index] += (direction * step) / speed;
        });
        
        updatePosition();
        
        // Clear existing timeout
        if (manualTimeout) clearTimeout(manualTimeout);
        
        // Re-enable scroll after 2 seconds
        manualTimeout = setTimeout(function() {
          isManual = false;
        }, 2000);
      }

      // Expose navigation
      if (!window.marqueeSliderControls) {
        window.marqueeSliderControls = {};
      }
      
      const sliderId = container.attr('id') || 'slider-' + index;
      window.marqueeSliderControls[sliderId] = {
        prev: function() { navigate(-1); },
        next: function() { navigate(1); }
      };

      // Scroll event
      $(window).on('scroll', function() {
        const containerTop = container.offset().top;
        const containerBottom = containerTop + container.outerHeight();
        const windowTop = $(window).scrollTop();
        const windowBottom = windowTop + $(window).height();

        if (windowBottom > containerTop && windowTop < containerBottom) {
          handleScroll();
        }
      });
    });
  };
})(jQuery);
