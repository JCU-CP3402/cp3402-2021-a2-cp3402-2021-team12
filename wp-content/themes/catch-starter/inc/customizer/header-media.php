<?php
/**
 * Header Media Options
 *
 * @package Catch_Starter
 */

function catch_starter_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'catch-starter' );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'catch_starter_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'catch-starter' ),
				'entire-site'            => esc_html__( 'Entire Site', 'catch-starter' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'catch-starter' ),
				'disable'                => esc_html__( 'Disabled', 'catch-starter' ),
			),
			'label'             => esc_html__( 'Enable on ', 'catch-starter' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_media_title',
			'default'           => esc_html__( 'Welcome to Catch Starter', 'catch-starter' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'catch-starter' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_media_text',
			'default'           => esc_html__( 'Make things as simple as possible but no simpler.', 'catch-starter' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'catch-starter' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'catch-starter' ),
			'section'           => 'header_image',
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_media_url_text',
			'default'           => esc_html__( 'Continue Reading', 'catch-starter' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'catch-starter' ),
			'section'           => 'header_image',
		)
	);

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_header_url_target',
			'sanitize_callback' => 'catch_starter_sanitize_checkbox',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'catch-starter' ),
			'section'           => 'header_image',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_starter_header_media_options' );

