<?php
/**
 * Blocks Initializer
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function bdpw_register_guten_block() {

	// Block Editor Script
	wp_register_script( 'bdpw-block-js', BDPW_URL.'assets/js/blocks.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ), BDPW_VERSION, true );

	wp_localize_script( 'bdpw-block-js', 'Bdpw_Block', array(
																'pro_demo_link'		=> 'https://demo.wponlinesupport.com/prodemo/blog-designer-post-and-widget/',
																'free_demo_link'	=> 'https://demo.wponlinesupport.com/blog-designer-post-and-widget/',
																'pro_link'			=> BDPW_PLUGIN_LINK,
															));

	// Register block and explicit attributes for post grid
	register_block_type( 'bdpw/wpspw-post', array(
		'attributes' => array(
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'grid' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'show_author' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_date' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_category_name' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_tags' =>  array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_comments' =>  array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_content' =>  array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_full_content' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'content_words_limit' =>  array(
							'type'		=> 'number',
							'default'	=> 20,
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 20,
						),
			'orderby' =>  array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' =>  array(
							'type'		=> 'string',
							'default'	=> 'desc',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'pagination' =>  array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'pagination_type' =>  array(
							'type'		=> 'string',
							'default'	=> 'numeric',
						),
			'sticky_posts' =>  array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'bdpw_get_posts',
	));

	// Register block and explicit attributes for recent post slider
	register_block_type( 'bdpw/wpspw-recent-post-slider', array(
		'attributes' => array(
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'show_author' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_date' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_category_name' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_tags' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_comments' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_content' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'content_words_limit' => array(
							'type'		=> 'number',
							'default'	=> 20,
						),
			'dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'slides_column' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'slides_scroll' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 2000,
						),
			'speed' => array(
							'type'		=> 'number',
							'default'	=> 300,
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 20,
						),
			'orderby' => array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' => array(
							'type'		=> 'string',
							'default'	=> 'desc',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'sticky_posts' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'bdpw_recent_post_slider',
	));

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'bdpw-block-js', 'blog-designer-for-post-and-widget', BDPW_DIR . '/languages' );
	}
}
add_action( 'init', 'bdpw_register_guten_block' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * 
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_editor_assets() {

	// Block Editor CSS
	if( ! wp_style_is( 'wpos-free-guten-block-css', 'registered' ) ) {
		wp_register_style( 'wpos-free-guten-block-css', BDPW_URL.'assets/css/blocks.editor.build.css', array( 'wp-edit-blocks' ), BDPW_VERSION );
	}
	
	// Block Editor Script - Style
	wp_enqueue_style( 'wpos-free-guten-block-css' );
	wp_enqueue_script( 'bdpw-block-js' );
}
add_action( 'enqueue_block_editor_assets', 'bdpw_editor_assets' );

/**
 * Adds an extra category to the block inserter
 *
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */
function bdpw_add_block_category( $categories ) {

	$guten_cats = wp_list_pluck( $categories, 'slug' );

	if( ! in_array( 'wpos_guten_block', $guten_cats ) ) {
		$categories[] = array(
							'slug'	=> 'wpos_guten_block',
							'title'	=> esc_html__('WPOS Blocks', 'blog-designer-for-post-and-widget'),
							'icon'	=> null,
						);
	}

	return $categories;
}
add_filter( 'block_categories', 'bdpw_add_block_category' );