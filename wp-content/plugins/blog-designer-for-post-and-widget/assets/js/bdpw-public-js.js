( function( $ ) {

    "use strict";
	
	bdpw_post_slider_init();

    /* Elementor Compatibility */
    $(document).on('click', '.elementor-tab-title', function() {

        var ele_control = $(this).attr('aria-controls');
        var slider_wrap = $('#'+ele_control).find('.sp_wpspwpost_slider');

        /* Tweak for slick slider */
        $( slider_wrap ).each(function( index ) {
            var slider_id = $(this).attr('id');
            $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

            setTimeout(function() {
                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                }
            }, 350);
        });
    });

    /* SiteOrigin Compatibility For Accordion Panel */
    $(document).on('click', '.sow-accordion-panel', function() {

        var ele_control     = $(this).attr('data-anchor');
        var slider_wrap     = $('#accordion-content-'+ele_control).find('.sp_wpspwpost_slider');

        /* Tweak for slick slider */
        $( slider_wrap ).each(function( index ) {
            var slider_id = $(this).attr('id');

            if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                $('#'+slider_id).slick( 'setPosition' );
            }
        });
    });

    /* SiteOrigin Compatibility for Tab Panel */
    $(document).on('click focus', '.sow-tabs-tab', function() {
        var sel_index   = $(this).index();
        var cls_ele     = $(this).closest('.sow-tabs');
        var tab_cnt     = cls_ele.find('.sow-tabs-panel').eq( sel_index );
        var slider_wrap = tab_cnt.find('.sp_wpspwpost_slider');

        /* Tweak for slick slider */
        $( slider_wrap ).each(function( index ) {
            var slider_id = $(this).attr('id');
            $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

            setTimeout(function() {
                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                }
            }, 300);
        });
    });

    /* Beaver Builder Compatibility for Accordion and Tab */
    $(document).on('click', '.fl-accordion-button, .fl-tabs-label', function() {

        var ele_control     = $(this).attr('aria-controls');
        var slider_wrap     = $('#'+ele_control).find('.sp_wpspwpost_slider');

        /* Tweak for slick slider */
        $( slider_wrap ).each(function( index ) {

            var slider_id = $(this).attr('id');
            $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

            setTimeout(function() {
                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                }
            }, 300);
        });
    });

    /* Divi Builder Compatibility for Accordion & Toggle */
    $(document).on('click', '.et_pb_toggle', function() {

        var acc_cont        = $(this).find('.et_pb_toggle_content');
        var slider_wrap     = acc_cont.find('.sp_wpspwpost_slider');

        /* Tweak for slick slider */
        $( slider_wrap ).each(function( index ) {

            var slider_id = $(this).attr('id');

            if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                $('#'+slider_id).slick( 'setPosition' );
            }
        });
    });

    /* Divi Builder Compatibility for Tabs */
    $('.et_pb_tabs_controls li a').click( function() {
        var cls_ele         = $(this).closest('.et_pb_tabs');
        var tab_cls         = $(this).closest('li').attr('class');
        var tab_cont        = cls_ele.find('.et_pb_all_tabs .'+tab_cls);
        var slider_wrap     = tab_cont.find('.sp_wpspwpost_slider');

        setTimeout(function() {

            /* Tweak for slick slider */
            $( slider_wrap ).each(function( index ) {

                var slider_id = $(this).attr('id');

                $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                }
            });

        }, 550);
    });

    /* Fusion Builder Compatibility for Tabs */
    $(document).on('click', '.fusion-tabs li .tab-link', function() {
        var cls_ele         = $(this).closest('.fusion-tabs');
        var tab_id          = $(this).attr('href');
        var tab_cont        = cls_ele.find(tab_id);
        var slider_wrap     = tab_cont.find('.sp_wpspwpost_slider');

        /* Tweak for slick slider default */
        $( slider_wrap ).each(function( index ) {

            var slider_id   = $(this).attr('id');
            $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

            setTimeout(function() {
                /* Tweak for slick slider */
                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                    $('#'+slider_id).slick( 'setPosition' );
                }
            }, 200);
        });
    });

    /* Fusion Builder Compatibility for Toggles */
    $(document).on('click', '.fusion-accordian .panel-heading a', function() {
        var cls_ele         = $(this).closest('.fusion-accordian');
        var tab_id          = $(this).attr('href');
        var tab_cont        = cls_ele.find(tab_id);
        var slider_wrap     = tab_cont.find('.sp_wpspwpost_slider');

        /* Tweak for slick slider default */
        $( slider_wrap ).each(function( index ) {

            var slider_id   = $(this).attr('id');
            $('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

            /* Tweak for slick slider */
            setTimeout(function() {
                if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
                    $('#'+slider_id).slick( 'setPosition' );
                    $('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
                    $('#'+slider_id).slick( 'setPosition' );
                }
            }, 200);
        });
    });

})( jQuery );


/* Function to Initialize Post Slider */
function bdpw_post_slider_init() {

    // Initialize slick slider
    jQuery( '.sp_wpspwpost_slider' ).each(function( index ) {
        
        if( jQuery(this).hasClass('slick-initialized') ) {
            return;
        }

        // Flex Condition
        if(Bdpw.is_avada == 1) {
            jQuery(this).closest('.fusion-flex-container').addClass('wpspw-fusion-flex');
        }

        var slider_id   = jQuery(this).attr('id');
        var slider_conf = JSON.parse( jQuery(this).parent('.wpspw-slider-wrp').find('.wpspw-slider-conf').text() );

        if( typeof(slider_id) != 'undefined' && slider_id != '' ) {

                var blogdesign          = parseInt(slider_conf.slides_column);
                var slides_to_scroll    = parseInt(slider_conf.slides_scroll);

                // Slider responsive breakpoints
                var slider_res = [{
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: (blogdesign > 3) ? 3 : blogdesign,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: (blogdesign > 2) ? 2 : blogdesign,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                },
                {
                    breakpoint: 319,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                }]

            jQuery('#'+slider_id).slick({
                infinite        : true,
                lazyLoad        : slider_conf.lazyload,
                slidesToShow    : blogdesign,
                slidesToScroll  : slides_to_scroll,
                dots            : ( slider_conf.dots == "true" ) ? true : false,
                arrows          : ( slider_conf.arrows == "true" ) ? true : false,
                autoplay        : ( slider_conf.autoplay == "true" ) ? true : false,
                autoplaySpeed   : parseInt( slider_conf.autoplay_interval ),
                speed           : parseInt( slider_conf.speed ),
                rtl             : ( Bdpw.is_rtl == "1" ) ? true : false,
                mobileFirst     : ( Bdpw.is_mobile == "1" ) ? true : false,
                responsive      : slider_res
            });
        }
    });
}