
	if(window,innerWidth > 550)
	{
		$('.socialmedia-slider').marqueeSlider([
		{ sensitivity: 1, repeatItems: true },
		{ sensitivity: 1, repeatItems: true }]);
		
	}else{

		$('.socialmedia-slider').marqueeSlider([
			{ sensitivity: 5, repeatItems:  empty},
			{ sensitivity: 5, repeatItems: empty }]);
			
	}

