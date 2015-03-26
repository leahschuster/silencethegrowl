<?php
/**
 * UWD Script Functions
 *
 * @package UWD
 * 
 * @since   1.0
 */ 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Enqueue scripts and styles. 
 * @return [type] [description]
 */
function uwd_enqueue_scripts_styles()
{

    $js_path  = get_stylesheet_directory_uri() . '/assets/js/';
    $css_path = get_stylesheet_directory_uri() . '/assets/css/';

    //Register & Enqueue Scripts

    wp_enqueue_script( 'jquery' );



    wp_register_script( 'app', $js_path. 'app.js', array('jquery'), 1234, true );
    wp_enqueue_script( 'app' );




    // wp_register_script( 'donate', $js_path. 'donate.js', array('jquery'), 1234, true );
    // wp_enqueue_script( 'donate' );




}
add_action('wp_enqueue_scripts', 'uwd_enqueue_scripts_styles' );