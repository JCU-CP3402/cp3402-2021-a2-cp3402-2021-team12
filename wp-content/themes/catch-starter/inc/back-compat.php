<?php
/**
 * Catch Starter back compat functionality
 *
 * Prevents Catch Starter from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @package Catch_Starter
 */

/**
 * Prevent switching to Catch Starter on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Catch Starter 0.1
 */
function catch_starter_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'catch_starter_upgrade_notice' );
}
add_action( 'after_switch_theme', 'catch_starter_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Catch Starter on WordPress versions prior to 4.4.
 *
 * @since Catch Starter 0.1
 *
 * @global string $wp_version WordPress version.
 */
function catch_starter_upgrade_notice() {
	/* translators: %s: current WordPress version. */
	$message = sprintf( __( 'Catch Starter requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'catch-starter' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );// WPCS: XSS ok.
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since Catch Starter 0.1
 *
 * @global string $wp_version WordPress version.
 */
function catch_starter_customize() {
	/* translators: %s: current WordPress version. */
	$message = sprintf( __( 'Catch Starter requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'catch-starter' ), $GLOBALS['wp_version'] );

	wp_die( $message, '', array( // WPCS: XSS ok.
		'back_link' => true,
	) ); // WPCS: XSS ok.
}
add_action( 'load-customize.php', 'catch_starter_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since Catch Starter 0.1
 *
 * @global string $wp_version WordPress version.
 */
function catch_starter_preview() {
	if ( isset( $_GET['preview'] ) ) {
		/* translators: %s: current WordPress version. */
		wp_die( sprintf( __( 'Catch Starter requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'catch-starter' ), $GLOBALS['wp_version'] ) );// WPCS: XSS ok.
	}
}
add_action( 'template_redirect', 'catch_starter_preview' );
