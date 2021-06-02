<?php
/**
 * 'wpspw_post' Shortcode
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `wpspw_post` shortcode
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_get_posts( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ($_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json') ) {
		return "[wpspw_post]";
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="bdpw-builder-shrt-prev">
					<div class="bdpw-builder-shrt-title"><span>'.esc_html__('Post Grid View - Shortcode', 'blog-designer-for-post-and-widget').'</span></div>
					wpspw_post
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="bdpw-builder-shrt-prev">
					<div class="bdpw-builder-shrt-title"><span>'.esc_html__('Post Grid View - Shortcode', 'blog-designer-for-post-and-widget').'</span></div>
					wpspw_post
				</div>';
	}

	// Taking some globals
	global $post, $multipage, $paged;

	// Shortcode Parameters
	extract(shortcode_atts(array(
		'limit' 				=> 20,
		'category' 				=> '',
		'grid' 					=> 1,
		'design' 				=> 'design-1',
		'show_author' 			=> 'true',
		'show_date' 			=> 'true',
		'show_category_name' 	=> 'true',
		'show_full_content' 	=> 'false',
		'show_content' 			=> 'true',
		'content_words_limit' 	=> 20,
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'sticky_posts'   		=> 'false',
		'show_tags'				=> 'true',
		'show_comments'			=> 'true',
		'pagination'			=> 'true',
		'pagination_type'		=> 'numeric',
		'extra_class'			=> '',
		'className'				=> '',
		'align'					=> '',
	), $atts, 'wpspw_post'));

	$posts_per_page 	= ! empty( $limit ) 					? $limit 						: 20;
	$design 			= ! empty( $design ) 					? $design 						: 'design-1';
	$cat 				= ! empty( $category )					? explode( ',',$category ) 		: '';
	$gridcol			= ! empty( $grid ) 						? $grid 						: 1;
	$show_author 		= ( $show_author == 'true' )			? 'true'						: 'false';
	$show_date 			= ( $show_date == 'true' ) 				? 'true'						: 'false';
	$show_category 		= ( $show_category_name == 'true' ) 	? 'true' 						: 'false';
	$show_content 		= ( $show_content == 'true' ) 			? 'true' 						: 'false';
	$words_limit 		= ! empty( $content_words_limit ) 		? $content_words_limit 			: 20;
	$show_full_content 	= ( $show_full_content == 'true' )		? 'true' 						: 'false';
	$order 				= ( strtolower( $order ) == 'asc' ) 	? 'ASC' 						: 'DESC';
	$orderby 			= ! empty( $orderby )					? $orderby 						: 'date';
	$sticky_posts		= ( $sticky_posts == 'true' )			? false							: true;
	$show_tags 			= ( $show_tags == 'true' ) 				? 'true'						: 'false';
	$show_comments 		= ( $show_comments == 'true' ) 			? 'true'						: 'false';
	$postpagination 	= ( $pagination == 'false' )			? 'false'						: 'true';
	$pagination_type 	= ( $pagination_type == 'prev-next' )	? 'prev-next' 					: 'numeric';
	$align				= ! empty( $align )						? 'align'.$align				: '';
	$extra_class		= $extra_class .' '. $align .' '. $className;
	$extra_class		= bdpw_get_sanitize_html_classes( $extra_class );
	$multi_page			= ( $multipage || is_single() || is_front_page() ) ? 1 : 0;

	// Taking some variables
	$count 	= 0;

	// Pagination parameter
	$paged = 1;
	if( $multi_page ) {
		$paged = isset( $_GET['blog_post_page'] ) ? $_GET['blog_post_page'] : 1;
	} else if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} else if ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	// WP Query Parameters
	$args = array ( 
		'post_type' 			=> BDPW_POST_TYPE,
		'post_status' 			=> array('publish'),
		'order'					=> $order,
		'orderby'				=> $orderby,
		'ignore_sticky_posts' 	=> $sticky_posts,
		'posts_per_page' 		=> $posts_per_page,
		'paged'					=> ( $postpagination ) ? $paged : 1,
	);

	// Category Parameter
	if($cat != "") {

		$args['tax_query'] = array(
								array( 
									'taxonomy' 			=> BDPW_CAT,
									'field' 			=> 'term_id',
									'terms' 			=> $cat,
								));
	}

	// WP Query
	$query 		= new WP_Query($args);
	$post_count = $query->post_count;

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {
?>

		<div class="sp_wpspwpost_static wpspw-<?php echo $design; ?> wpspw-grid-<?php echo $gridcol; ?> wpspw-clearfix <?php echo $extra_class; ?>">

			<?php while ( $query->have_posts() ) : $query->the_post();

				$count++;
				$css_class 		= '';
				$news_links 	= array();
				$feat_image 	= bdpw_get_post_featured_image( $post->ID, 'full', true );
				$terms 			= get_the_terms( $post->ID, 'category' );
				$tags 			= get_the_tag_list(__('Tags:', 'blog-designer-for-post-and-widget'),', ');
				$comments 		= get_comments_number( $post->ID );
				$reply			= ($comments <= 1)  ? __('Reply', 'blog-designer-for-post-and-widget') : __('Replies', 'blog-designer-for-post-and-widget');

				if($terms) {
					foreach ( $terms as $term ) {
						$term_link = get_term_link( $term );
						$news_links[] = '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
					}
				}
				$cate_name = join( " ", $news_links );

				if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == ($count - 1) % $grid ) ) || 1 == $count ) { $css_class .= ' first'; }
				if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == $count % $grid ) ) || $post_count == $count ) { $css_class .= ' last'; }

				// Include shortcode html file
				include( BDPW_DIR.'/templates/grid/'."$design".'.php' );

			endwhile; ?>

			<?php if( $postpagination == "true" && ($query->max_num_pages > 1) ) { ?>
			<div class="wpspw_pagination wpspw-<?php echo $pagination_type; ?> wpspw-clearfix">

				<?php if($pagination_type == "numeric" || ($multi_page && $pagination_type == "prev-next") ) {
					echo bdpw_post_pagination( array( 'paged' => $paged , 'total' => $query->max_num_pages, 'pagination_type' => $pagination_type, 'multi_page' => $multi_page ) );
				} else { ?>
					<div class="wpspw-pagi-btn wpspw-prev-btn"><?php next_posts_link( __('Next', 'blog-designer-for-post-and-widget').' &raquo;', $query->max_num_pages ); ?></div>
					<div class="wpspw-pagi-btn wpspw-next-btn"><?php previous_posts_link( '&laquo; '.__('Previous', 'blog-designer-for-post-and-widget') ); ?> </div>
				<?php } ?>
			</div><!-- end .blog_pagination -->
			<?php } ?>

		</div><!-- end .sp_wpspwpost_static -->

	<?php } // end of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// 'wpspw_post' Shortcode
add_shortcode('wpspw_post', 'bdpw_get_posts');