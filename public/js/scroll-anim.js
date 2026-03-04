
	if(window.innerWidth > 550)
	{
		$('.socialmedia-slider').marqueeSlider([
		{ sensitivity: 1, repeatItems: true },
		{ sensitivity: 1, repeatItems: true }]);
		
	}else{

		$('.socialmedia-slider').marqueeSlider([
			{ sensitivity: 5, repeatItems: false},
			{ sensitivity: 5, repeatItems: false }]);
			
	}
	
	// Initialize navigation buttons after slider is ready
	setTimeout(function() {
		$('#slider-prev').on('click', function() {
			if (window.marqueeSliderControls && window.marqueeSliderControls['social-slider']) {
				window.marqueeSliderControls['social-slider'].prev();
			}
		});

		$('#slider-next').on('click', function() {
			if (window.marqueeSliderControls && window.marqueeSliderControls['social-slider']) {
				window.marqueeSliderControls['social-slider'].next();
			}
		});
	}, 100);

