<?php
/**
 * 'wpspw_recent_post_slider' Shortcode
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `wpspw_recent_post_slider` shortcode
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_recent_post_slider( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ($_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json') ) {
		return "[wpspw_recent_post_slider]";
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="bdpw-builder-shrt-prev">
					<div class="bdpw-builder-shrt-title"><span>'.esc_html__('Post Slider View - Shortcode', 'blog-designer-for-post-and-widget').'</span></div>
					wpspw_recent_post_slider
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="bdpw-builder-shrt-prev">
					<div class="bdpw-builder-shrt-title"><span>'.esc_html__('Post Grid View - Shortcode', 'blog-designer-for-post-and-widget').'</span></div>
					wpspw_recent_post_slider
				</div>';
	}

	// Shortcode Parameters
	extract(shortcode_atts(array(
				'limit' 				=> 20,
				'design' 				=> 'design-1',
				'category' 				=> '',
				'show_author' 			=> 'true',
				'show_date' 			=> 'true',
				'show_category_name' 	=> 'true',
				'show_content' 			=> 'true',
				'content_words_limit' 	=> 20,
				'order'					=> 'DESC',
				'orderby'				=> 'date',
				'sticky_posts'   		=> 'false',
				'show_tags'				=> 'true',
				'slides_column' 		=> 1,
				'slides_scroll' 		=> 1,
				'dots' 					=> 'true',
				'arrows'				=> 'true',
				'autoplay' 				=> 'true',
				'autoplay_interval' 	=> 2000,
				'speed' 				=> 300,
				'show_comments'			=> 'true',
				'lazyload'				=> '',
				'extra_class'			=> '',
				'className'				=> '',
				'align'					=> '',
	), $atts, 'wpspw_recent_post_slider'));

	$posts_per_page 		= ! empty( $limit ) 					? $limit 						: 20;
	$design 	            = ! empty( $design ) 					? $design 						: 'design-1';
	$cat 					= ! empty( $category )					? explode(',',$category) 		: '';
	$show_date 				= ( $show_date == 'true' ) 				? 'true'						: 'false';
	$show_category 			= ( $show_category_name == 'true' )		? 'true' 						: 'false';
	$show_content 			= ( $show_content == 'true' ) 			? 'true' 						: 'false';
	$words_limit 			= ! empty( $content_words_limit ) 		? $content_words_limit	 		: 20;
	$order 					= ( strtolower( $order ) == 'asc' ) 	? 'ASC' 						: 'DESC';
	$orderby 				= ! empty( $orderby )					? $orderby 						: 'date';
	$sticky_posts			= ( $sticky_posts == 'true' )			? false							: true;
	$show_tags 				= ( $show_tags == 'true' ) 				? 'true'						: 'false';
	$slides_column 			= ! empty( $slides_column ) 			? $slides_column 				: 1;
	$slides_scroll 			= ! empty( $slides_scroll ) 			? $slides_scroll 				: 1;
	$dots 					= ( $dots == 'false' )					? 'false' 						: 'true';
	$arrows 				= ( $arrows == 'false' )				? 'false' 						: 'true';
	$autoplay 				= ( $autoplay == 'false' )				? 'false' 						: 'true';
	$autoplay_interval 		= ! empty( $autoplay_interval ) 		? $autoplay_interval 			: 2000;
	$speed 					= ! empty( $speed ) 					? $speed 						: 300;
	$show_author 			= ( $show_author == 'true' )			? 'true'						: 'false';
	$show_comments 			= ( $show_comments == 'true' ) 			? 'true'						: 'false';
	$lazyload 				= ( $lazyload == 'ondemand' || $lazyload == 'progressive' ) ? $lazyload 	: ''; // ondemand or progressive
	$align					= ! empty( $align )						? 'align'.$align				: '';
	$extra_class			= $extra_class .' '. $align .' '. $className;
	$extra_class			= bdpw_get_sanitize_html_classes( $extra_class );

	// Taking some globals
	global $post;

	// Enqueue required script
	wp_enqueue_script( 'wpos-slick-jquery' );
	wp_enqueue_script( 'bdpw-public-js' );

	// Slider configuration
	$slider_conf = compact( 'slides_column', 'slides_scroll', 'dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'lazyload');

	// Taking some variables
	$unique	= bdpw_get_unique();

	$args = array ( 
		'post_type' 			=> BDPW_POST_TYPE,
		'post_status' 			=> array('publish'),
		'order'					=> $order,
		'orderby'				=> $orderby,
		'posts_per_page' 		=> $posts_per_page,
		'ignore_sticky_posts' 	=> $sticky_posts,
	);

	// Category Parameter
	if($cat != "") {
		$args['tax_query'] = array(
								array(
									'taxonomy' 	=> BDPW_CAT,
									'field' 	=> 'term_id',
									'terms' 	=> $cat
								));
	}

	// WP Query
	$query = new WP_Query($args);

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {
?>
	<div class="wpspw-slider-wrp <?php echo $extra_class; ?>">
		<div id="wpspw-slider-<?php echo $unique; ?>" class="sp_wpspwpost_slider wpspw-<?php echo $design; ?>">

			<?php while ( $query->have_posts() ) : $query->the_post();

				$terms 		= get_the_terms( $post->ID, BDPW_CAT );
				$blog_links = array();

				if($terms) {
					foreach ( $terms as $term ) {
						$term_link 		= get_term_link( $term );
						$blog_links[] 	= '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
					}
				}

				$cate_name 		= join( " ", $blog_links );
				$feat_image 	= bdpw_get_post_featured_image( $post->ID );
				$terms 			= get_the_terms( $post->ID, BDPW_CAT );
				$tags 			= get_the_tag_list( __('Tags: ','blog-designer-for-post-and-widget'),', ');
				$comments 		= get_comments_number( $post->ID );
				$reply			= ($comments <= 1)  ? __('Reply','blog-designer-for-post-and-widget') : __('Replies','blog-designer-for-post-and-widget');

				// Include shortcode html file
				include( BDPW_DIR.'/templates/slider/'."$design".'.php' );

			endwhile; ?>
		</div>
		<div class="wpspw-slider-conf"><?php echo htmlspecialchars(json_encode( $slider_conf )); ?></div>
	</div><!-- end .wpspw-slider-wrp -->

<?php
	} // End if

	wp_reset_postdata(); // Reset Query

	$content .= ob_get_clean();
	return $content; 
}

// 'wpspw_recent_post_slider' Shortcode
add_shortcode('wpspw_recent_post_slider', 'bdpw_recent_post_slider');