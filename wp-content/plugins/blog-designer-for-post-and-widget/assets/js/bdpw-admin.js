( function( $ ) {

    "use strict";

    /* Click to Copy the Text */
    $(document).on('click', '.wpos-copy-clipboard', function() {
        var copyText = $(this);
        copyText.select();
        document.execCommand("copy");
    });

    /* Drag widget event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.preview-rendered', bdpw_fl_render_preview );

	/* Save widget event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.layout-rendered', bdpw_fl_render_preview );

	/* Publish button event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.didSaveNodeSettings', bdpw_fl_render_preview );
})( jQuery );

/* Function to render shortcode preview for Beaver Builder */
function bdpw_fl_render_preview() {
	bdpw_post_slider_init();
}