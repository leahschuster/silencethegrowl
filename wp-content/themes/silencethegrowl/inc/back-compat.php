<?php
/**
 * Silence the Growl back compat functionality
 *
 * Prevents Silence the Growl from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 *
 * @package WordPress
 * @subpackage Quarter_Campaign
 * @since Quarter Campaign 1.0 2015
 */

/**
 * Prevent switching to Silence the Growl on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'silencethegrowl_upgrade_notice' );
}
add_action( 'after_switch_theme', 'silencethegrowl_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Silence the Growl on WordPress versions prior to 4.1.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_upgrade_notice() {
	$message = sprintf( __( 'Silence the Growl requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'silencethegrowl' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_customize() {
	wp_die( sprintf( __( 'Silence the Growl requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'silencethegrowl' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'silencethegrowl_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Silence the Growl requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'silencethegrowl' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'silencethegrowl_preview' );
