<?php
/**
* The template for adding Service Settings in Customizer
*
 * @package Catch_Starter
*/

function catch_starter_service_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
    catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_jetpack_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'label'             => sprintf( esc_html__( 'For Service Options for Catch Starter Theme, go %1$shere%2$s', 'catch-starter' ),
                 '<a href="javascript:wp.customize.section( \'catch_starter_service\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'ect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'catch_starter_service', array(
			'panel'    => 'catch_starter_theme_options',
			'title'    => esc_html__( 'Service', 'catch-starter' ),
		)
	);

	catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'active_callback'   => 'catch_starter_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Content Type Enabled', 'catch-starter' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'catch_starter_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_starter_sanitize_select',
			'active_callback'   => 'catch_starter_is_ect_service_active',
			'choices'           => catch_starter_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-starter' ),
			'section'           => 'catch_starter_service',
			'type'              => 'select',
		)
	);

     catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'active_callback'   => 'catch_starter_is_service_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-starter' ),
                '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                '</a>'
            ),
            'section'           => 'catch_starter_service',
            'type'              => 'description',
        )
    );

	catch_starter_register_option( $wp_customize, array(
				'name'              => 'catch_starter_service_number',
				'default'           => 6,
				'sanitize_callback' => 'catch_starter_sanitize_number_range',
				'active_callback'   => 'catch_starter_is_service_active',
				'description'       => esc_html__( 'Save and refresh the page if No. of Service is changed', 'catch-starter' ),
				'input_attrs'       => array(
					'style' => 'width: 45px;',
					'min'   => 0,
				),
				'label'             => esc_html__( 'No of Service', 'catch-starter' ),
				'section'           => 'catch_starter_service',
				'type'              => 'number',
		)
	);

	$number = get_theme_mod( 'catch_starter_service_number', 6 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		//for CPT
		catch_starter_register_option( $wp_customize, array(
				'name'              => 'catch_starter_service_cpt_' . $i,
				'sanitize_callback' => 'catch_starter_sanitize_post',
				'default'           => 0,
				'active_callback'   => 'catch_starter_is_service_active',
				'label'             => esc_html__( 'Service ', 'catch-starter' ) . ' ' . $i ,
				'section'           => 'catch_starter_service',
				'type'              => 'select',
				'choices'           => catch_starter_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'catch_starter_service_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_starter_is_service_active' ) ) :
    /**
    * Return true if portfolio content is active
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_service_active( $control ) {
        $enable = $control->manager->get_setting( 'catch_starter_service_option' )->value();

        //return true only if previewed page on customizer matches the type of content option selected
        return ( catch_starter_check_section( $enable ) && catch_starter_is_ect_service_active( $control ) );
    }
endif;

if ( ! function_exists( 'catch_starter_is_ect_service_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'catch_starter_is_ect_service_inactive' ) ) :
    /**
    * Return true if portfolio is inactive
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;