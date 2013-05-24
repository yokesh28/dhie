function mycarousel_initCallback(carousel)
{
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
								
 if ( $.browser.msie ) {
  	$('div.wrapper_product').addClass('hideshow-hover');
 } else {
   	$('div.wrapper_product').css({opacity: 0.0});
 }

    jQuery('.bullet-slider').jcarousel({
        wrap: 'last',
        visible: 4,
		scroll : 1,
		animation: 1000,
        initCallback: mycarousel_initCallback
    });
});

$(document).ready(function(){
 if ( $.browser.msie ) {
 $(".jcarousel-item").hover(function() {
		$("div.wrapper_product",this).removeClass('hideshow-hover');

	}, function() {
		$("div.wrapper_product",this).addClass('hideshow-hover');
		
	});
 } else {
   $(".jcarousel-item").hover(function() {
		$("div.wrapper_product",this).stop()
		.animate({bottom: "0", opacity:1},{queue:true,duration:800})
		.css("display","block")

	}, function() {
		$("div.wrapper_product",this).stop()
		.animate({bottom: "-30", opacity: 0},{queue:true,duration:300})
	});
 }
	

});