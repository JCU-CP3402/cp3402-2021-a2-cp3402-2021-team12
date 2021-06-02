<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Catch_Starter
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_starter_portfolio_options( $wp_customize ) {
    // Add note to Jetpack Portfolio Section
    catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'label'             => sprintf( esc_html__( 'For Portfolio Options for Catch Starter Theme, go %1$shere%2$s', 'catch-starter' ),
                 '<a href="javascript:wp.customize.section( \'catch_starter_portfolio\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'jetpack_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'catch_starter_portfolio', array(
            'panel'    => 'catch_starter_theme_options',
            'title'    => esc_html__( 'Portfolio', 'catch-starter' ),
        )
    );

    catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_portfolio_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'active_callback'   => 'catch_starter_is_ect_portfolio_inactive',
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Content Type Enabled', 'catch-starter' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'catch_starter_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    catch_starter_register_option( $wp_customize, array(
			'name'              => 'catch_starter_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_starter_sanitize_select',
            'active_callback'   => 'catch_starter_is_ect_portfolio_active',
			'choices'           => catch_starter_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-starter' ),
			'section'           => 'catch_starter_portfolio',
			'type'              => 'select',
		)
	);

    catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Starter_Note_Control',
            'active_callback'   => 'catch_starter_is_portfolio_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-starter' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'catch_starter_portfolio',
            'type'              => 'description',
        )
    );

    catch_starter_register_option( $wp_customize, array(
            'name'              => 'catch_starter_portfolio_number',
            'default'           => '6',
            'sanitize_callback' => 'catch_starter_sanitize_number_range',
            'active_callback'   => 'catch_starter_is_portfolio_active',
            'label'             => esc_html__( 'Number of items to show', 'catch-starter' ),
            'section'           => 'catch_starter_portfolio',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'catch_starter_portfolio_number', 6 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        catch_starter_register_option( $wp_customize, array(
                'name'              => 'catch_starter_portfolio_cpt_' . $i,
                'sanitize_callback' => 'catch_starter_sanitize_post',
                'active_callback'   => 'catch_starter_is_portfolio_active',
                'label'             => esc_html__( 'Portfolio', 'catch-starter' ) . ' ' . $i ,
                'section'           => 'catch_starter_portfolio',
                'type'              => 'select',
                'choices'           => catch_starter_generate_post_array( 'jetpack-portfolio' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'catch_starter_portfolio_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_starter_is_portfolio_active' ) ) :
    /**
    * Return true if portfolio content is active
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_portfolio_active( $control ) {
        $enable = $control->manager->get_setting( 'catch_starter_portfolio_option' )->value();

        //return true only if previewed page on customizer matches the type of content option selected
        return ( catch_starter_check_section( $enable ) && catch_starter_is_ect_portfolio_active( $control ) );
    }
endif;

if ( ! function_exists( 'catch_starter_is_ect_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'catch_starter_is_ect_portfolio_inactive' ) ) :
    /**
    * Return true if portfolio is inactive
    *
    * @since Catch Starter 0.1
    */
    function catch_starter_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;