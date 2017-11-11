jQuery(document).ready(function($) {

    var twitterSlider = $('.widget_custom_twitter_feed_widget');

    if( twitterSlider.length > 0 ) {
        twitterSlider.flexslider({
            animation: "slide",
            slideshowSpeed: 6000,
            direction: "vertical",
            directionNav: false,
            controlNav: false,
            pauseOnHover: true,
            useCSS: false
        });
    }

});