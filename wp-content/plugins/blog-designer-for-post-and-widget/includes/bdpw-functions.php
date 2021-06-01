<?php
/**
 * Plugin generic functions file
 *
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to unique number value
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0.0
 */
function bdpw_get_unique() {
	static $unique = 0;
	$unique++;

	// For Elementor & Beaver Builder
	if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
	|| ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) )
	|| ( function_exists('vc_is_inline') && vc_is_inline() ) ) {
		$unique = current_time('timestamp') . '-' . rand();
	}

	return $unique;
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0.0
 */
function bdpw_get_sanitize_html_classes($classes, $sep = " ") {
    $return = "";

    if( !is_array($classes) ) {
        $classes = explode($sep, $classes);
    }

    if( !empty($classes) ) {
        foreach($classes as $class){
            $return .= sanitize_html_class($class) . " ";
        }
        $return = trim( $return );
    }

    return $return;
}

/**
 * Function to add array after specific key
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count    = count($array);
			$index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}

		$split_arr  = array_splice($array, max(0, $index));
		$array      = array_merge( $array, $value, $split_arr);
	}

	return $array;
}

/**
 * Function to get post featured image
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_get_post_featured_image( $post_id = '', $size = 'full', $default_img = false ) {

	$size   = !empty($size) ? $size : 'full';

	$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	return $image;
}

/**
 * Function to get post excerpt
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	$has_excerpt    = false;
	$word_length    = !empty($word_length) ? $word_length : '55';

	// If post id is passed
	if( !empty($post_id) ) {
		if (has_excerpt($post_id)) {

			$has_excerpt    = true;
			$content        = get_the_excerpt();

		} else {
			$content = !empty($content) ? $content : get_the_content();
		}
	}

	if( !empty($content) && (!$has_excerpt) ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}

	return $content;
}

/**
 * Pagination function for grid
 * 
 * @package  Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_post_pagination( $args = array() ) {

	$big				= 999999999; // need an unlikely integer
	$page_links_temp	= array();	
	$pagination_type	= isset( $args['pagination_type'] ) ? $args['pagination_type'] : 'numeric';
	$multi_page			= ! empty( $args['multi_page'] ) 	? 1 : 0;

	$paging = array(
		'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' 	=> '?paged=%#%',
		'current' 	=> max( 1, $args['paged'] ),
		'total' 	=> $args['total'],
		'prev_next'	=> true,
		'prev_text'	=> '&laquo; '.__('Previous', 'blog-designer-for-post-and-widget'),
		'next_text'	=> __('Next', 'blog-designer-for-post-and-widget').' &raquo;',
	);

	// If pagination is prev-next and shortcode is placed in single post
	if( $multi_page ) {
		$paging['type']		= ( $pagination_type == 'prev-next' ) ? 'array' : 'plain';
		$paging['base']		= esc_url_raw( add_query_arg( 'blog_post_page', '%#%', false ) );
		$paging['format']	= '?blog_post_page=%#%';
	}

	$page_links = paginate_links( apply_filters( 'wpspw_pro_paging_args', $paging ) );

	// For single post shortcode we just fetch the prev-next link
	if( $pagination_type == 'prev-next' && $page_links && is_array( $page_links ) ) {

		foreach ($page_links as $page_link_key => $page_link) {
			if( strpos( $page_link, 'next page-numbers') !== false || strpos( $page_link, 'prev page-numbers') !== false ) {
				$page_links_temp[ $page_link_key ] = $page_link;
			}
		}
		return join( "\n", $page_links_temp );
	}

	return $page_links;
}