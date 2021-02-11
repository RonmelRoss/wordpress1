(function ($) {
	"use strict";
    
    //document ready function
    jQuery(document).ready(function($){
		var menu      =  $('#primary-menu');

       
		 $("#primary-menu").KeyboardAccessibleDropDown();

    }); // end document ready

    $.fn.KeyboardAccessibleDropDown = function () {
	    var el = $(this);
		
		/* Make dropdown menus keyboard accessible */
		$("a", el).focus(function() {
			$(this).parents("li").addClass("active-focus");
		}).blur(function() {
			$(this).parents("li").removeClass("active-focus");
		});
	}

}(jQuery));	