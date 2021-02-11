(function($) {
    "use strict";
     $(document).on('ready', function() {	

		// Post Slider JS
		$('.post-slider').slick({
			autoplay: false,
			autoplaySpeed: 2000,
			speed: 500,
			arrows: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			prevArrow: '<button class="PrevArrow"><span class="fa fa-angle-left"></span></button>',
			nextArrow: '<button class="NextArrow"><span class="fa fa-angle-right"></span></button>',
			pauseOnHover: false,
			dots: false,
			draggable: true,
			cssEase: 'linear'
		});	
		
		// Menu Click JS
		$('.menu-click,.close-menu a').on('click', function(){
			$('.menu-inner').toggleClass('active');
		});
		
		// Scroll top
		$('.scroll-top a').on('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top - 80 
			}, 1000, '');
			event.preventDefault();
		});
			
	});	
		
		// Preloader JS
		
		jQuery(window).load(function() {
			jQuery(".preloader-main").fadeOut('slow', function(){
				jQuery(this).remove();
			});
		});
})(jQuery);