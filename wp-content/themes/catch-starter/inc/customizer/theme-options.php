<?php
/**
 * Theme Options
 *
 * @package Catch_Starter
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_starter_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'catch_starter_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'catch-starter' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'catch_starter_breadcrumb_options', array(
		'description'   => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'catch-starter' ),
		'panel'         => 'catch_starter_theme_options',
		'title'         => esc_html__( 'Breadcrumb', 'catch-starter' ),
	) );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'catch_starter_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'catch-starter' ),
			'section'           => 'catch_starter_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_latest_posts_title',
			'default'           => esc_html__( 'News', 'catch-starter' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Latest Posts Title', 'catch-starter' ),
			'section'           => 'catch_starter_theme_options',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'catch_starter_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'catch-starter' ),
		'panel' => 'catch_starter_theme_options',
		)
	);

	/* Default Layout */
	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'catch_starter_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'catch-starter' ),
			'section'           => 'catch_starter_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-starter' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'catch-starter' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'catch_starter_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'catch-starter' ),
			'section'           => 'catch_starter_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-starter' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'catch-starter' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'catch_starter_excerpt_options', array(
		'panel'     => 'catch_starter_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'catch-starter' ),
	) );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_excerpt_length',
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 20 words', 'catch-starter' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'catch-starter' ),
			'section'  => 'catch_starter_excerpt_options',
			'type'     => 'number',
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'catch-starter' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'catch-starter' ),
			'section'           => 'catch_starter_excerpt_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'catch_starter_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'catch-starter' ),
		'panel'       => 'catch_starter_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'catch-starter' ),
	) );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_front_page_category',
			'sanitize_callback' => 'catch_starter_sanitize_category_list',
			'custom_control'    => 'Catch_Starter_Multi_Categories_Control',
			'label'             => esc_html__( 'Categories', 'catch-starter' ),
			'section'           => 'catch_starter_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'catch_starter_pagination_type', 'default' );

	$nav_desc = '';

	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'catch-starter' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'catch_starter_pagination_options', array(
		'description' => $nav_desc,
		'panel'       => 'catch_starter_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'catch-starter' ),
	) );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'catch_starter_sanitize_select',
			'choices'           => catch_starter_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'catch-starter' ),
			'section'           => 'catch_starter_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'catch_starter_scrollup', array(
		'panel'    => 'catch_starter_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'catch-starter' ),
	) );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_disable_scrollup',
			'sanitize_callback' => 'catch_starter_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'catch-starter' ),
			'section'           => 'catch_starter_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_starter_theme_options' );
