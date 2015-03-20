<?php
/**
 * Silence the Growl functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Quarter_Campaign
 * @since Quarter Campaign 1.0 2015
 */


/**
 * Silence the Growl only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'silencethegrowl_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on silencethegrowl, use a find and replace
	 * to change 'silencethegrowl' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'silencethegrowl', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'silencethegrowl' ),
		'social'  => __( 'Social Links Menu', 'silencethegrowl' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = silencethegrowl_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'silencethegrowl_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

}
endif; // silencethegrowl_setup
add_action( 'after_setup_theme', 'silencethegrowl_setup' );

/**
 * Register widget area.
 *
 * @since Quarter Campaign 1.0 2015
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function silencethegrowl_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'silencethegrowl' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'silencethegrowl' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'silencethegrowl_widgets_init' );



/**
 * Enqueue scripts and styles.
 *
 * @since Quarter Campaign 1.0 2015
 */
function silencethegrowl_scripts() {
	

	// Load our main stylesheet.
	wp_enqueue_style( 'silencethegrowl-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'silencethegrowl-main', get_template_directory_uri() . '/assets/css/style.css', array( 'silencethegrowl-style' ), '20141010' );
	wp_style_add_data( 'silencethegrowl-main' );






	wp_enqueue_script( 'silencethegrowl-script', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '20141212', true );
	wp_localize_script( 'silencethegrowl-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'silencethegrowl' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'silencethegrowl' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'silencethegrowl_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Quarter Campaign 1.0 2015
 *
 * @see wp_add_inline_style()
 */
function silencethegrowl_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'silencethegrowl-style', $css );
}
add_action( 'wp_enqueue_scripts', 'silencethegrowl_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Quarter Campaign 1.0 2015
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function silencethegrowl_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'silencethegrowl_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Quarter Campaign 1.0 2015
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function silencethegrowl_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'silencethegrowl_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Quarter Campaign 1.0 2015
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Quarter Campaign 1.0 2015
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Quarter Campaign 1.0 2015
 */
require get_template_directory() . '/inc/customizer.php';





////////////////////////////////////
//// FACEBOOK LIKES COUNTER ////////
////////////////////////////////////


if ( ! class_exists( 'Likes_Counter_Class' ) ) {
    final class Likes_Counter_Class {

        private static $_instance;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {
            $this->actions();
        }

        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'likes-counter' ), '1.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'likes-counter' ), '1.0' );
        }

        /**
         * Action Hooks.
         */
        private function actions(){
            add_action( 'plugins_loaded',  array( $this, 'load_text_domain' ) );
            add_shortcode( 'likescounter', array( $this, 'likes_counter' ) );
        }

        /**
         * Load Localisation Files.
         */
        public function load_text_domain() {
            $languages_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
            load_plugin_textdomain( 'likes-counter', $languages_dir );
        }

        /**
         * Get Likes from Facebook OpenGraph.
         *
         * @param string $page The page name or id number.
         * @param integer $expiration Cache duration for transient.
         *
         * @return integer|false
         */
        private function get_likes( $page, $expiration ) {
            $likes_transient = get_transient( 'likes_counter_' . strtolower( $page ) );

            if ( $likes_transient === false ) {
                $likes_data = json_decode( wp_remote_retrieve_body( wp_safe_remote_get( 'https://graph.facebook.com/' . $page ) ) );
                $likes = $likes_data -> likes;

                if ( ! is_null( $likes ) ) {
                    $likes = (int) $likes;
                    if ( $expiration > 0 && $expiration <= 1440 ) {
                        set_transient( 'likes_counter_' . strtolower( $page ), $likes, $expiration * MINUTE_IN_SECONDS );
                    } else {
                        set_transient( 'likes_counter_' . strtolower( $page ), $likes, 30 * MINUTE_IN_SECONDS );
                    }
                    return $likes;
                } else {
                    return false;
                }
            } else {
                $likes_transient = (int) $likes_transient;
                return $likes_transient;
            }
        }

        /**
         * Add span tag around each character.
         *
         * @param string|integer $number Number to add span tags.
         * @param string $tag True or false.
         *
         * @return string|integer
         */
        private function add_character_tag( $number, $tag ) {
            if ( $tag === 'false' ) {
                return $number;
            } else {
                $number_array = str_split( $number );
                $number_tag = '';
                foreach ( $number_array as $value ) {
                    if ( $value === ' ' || $value === ',' || $value === '.' ) {
                        $number_tag .= '<span class="likes-counter-separator">' . $value . '</span>';
                    } else if ( $value === 'K' || $value === 'M' || $value === 'B' ) {
                        $number_tag .= '<span class="likes-counter-separator">' . $value . '</span>';
                    } else {
                       $number_tag .= '<span class="likes-counter">' . $value . '</span>';
                    }
                }
                return $number_tag;
            }
        }

        /**
         * Add thousand separator.
         *
         * @param integer $number Number to add thousand separator.
         * @param string $type Thousand separator type.
         *
         * @return string|integer
         */
        private function add_separator( $number, $type ) {
            switch ( $type ) {
                case 'comma':
                    $number = number_format( $number, 0, '', ',' );
                    break;
                case 'dot':
                    $number = number_format( $number, 0, '', '.' );
                    break;
                case 'short':
                    if ( $number >= 1000 ) {
                        if ( $number < 10000 ) {
                            $number = substr( number_format( $number / 1000, 2 ), 0, -1 ) . 'K';
                        } else if ( $number < 1000000 ) {
                            $number = number_format( $number / 1000 ) . 'K';
                        } else if ( $number < 1000000000 ) {
                            $number = number_format( $number / 1000000 ) . 'M';
                        } else {
                            $number = number_format( $number / 1000000000 ) . 'B';
                        }
                    }
                    break;
                case 'space':
                    $number = number_format( $number, 0, '', ' ' );
                    break;
            }
            return $number;
        }

        /**
         * Subtract offset from number.
         *
         * @param integer $number Bigger number.
         * @param integer $offset Smaller number to subtract.
         *
         * @return integer The subtraction remainder.
         */
        private function add_offset( $number, $offset ) {
            if ( $offset > 0 && $offset <= $number ) {
                $number_offset = $number - $offset;
                return $number_offset;
            } else {
                return $number;
            }
        }

        /**
         * Likes Counter shortcode function.
         *
         * @param array $atts Shortcode attributes.
         *
         * @return string Formatted likes string.
         */
        public function likes_counter( $atts ) {
            $likes_options = shortcode_atts( array(
                'duration' => 30,
                'offset' => 0,
                'page' => '',
                'separator' => '',
                'tag' => 'true'
            ), $atts );

            $page = $likes_options[ 'page' ];
            $duration = (int) $likes_options[ 'duration' ];
            $likes = $this->get_likes( $page, $duration );

            if ( $likes === false ) {
                return __( 'Could not get likes data. Please verify if page is correct.', 'likes-counter' );
            } else {
                $offset = (int) $likes_options[ 'offset' ];
                $separator = $likes_options[ 'separator' ];
                $tag = $likes_options[ 'tag' ];
                return $this->add_character_tag( $this->add_separator( $this->add_offset( $likes, $offset ), $separator ), $tag );
            }
        }
    }
}

function Run_Likes_Counter_Class() {
    return Likes_Counter_Class::instance();
}

Run_Likes_Counter_Class();


/////// SOCIAL STATS SETTINGS ////////

add_action( 'admin_menu', 'FF_add_admin_menu' );
add_action( 'admin_init', 'FF_settings_init' );


function FF_add_admin_menu(  ) { 

    add_options_page( 'Social Media', 'Social Media', 'manage_options', 'social_media', 'FF_options_page' );

}


function FF_settings_init(  ) { 

    register_setting( 'pluginPage', 'FF_settings' );

    add_settings_section(
        'FF_pluginPage_section', 
        __( 'Fill out this information to get social stats on your site', 'uwd' ), 
        'FF_settings_section_callback', 
        'pluginPage'
    );

    add_settings_field( 
        'FF_facebook_account', 
        __( 'Facebook Account Name', 'uwd' ), 
        'FF_facebook_account_render', 
        'pluginPage', 
        'FF_pluginPage_section' 
    );

    add_settings_field( 
        'FF_twitter_handle', 
        __( 'Twitter Handle', 'uwd' ), 
        'FF_twitter_handle_render', 
        'pluginPage', 
        'FF_pluginPage_section' 
    );

    add_settings_field( 
        'FF_instagram_token', 
        __( 'Instagram Access Token', 'uwd' ), 
        'FF_instagram_token_render', 
        'pluginPage', 
        'FF_pluginPage_section' 
    );



}


function FF_facebook_account_render(  ) { 

    $options = get_option( 'FF_settings' );
    ?>
    <input type='text' name='FF_settings[FF_facebook_account]' value='<?php echo $options['FF_facebook_account']; ?>'>
    <?php

}


function FF_twitter_handle_render(  ) { 

    $options = get_option( 'FF_settings' );
    ?>
    <input type='text' name='FF_settings[FF_twitter_handle]' value='<?php echo $options['FF_twitter_handle']; ?>'>
    <?php

}


function FF_instagram_token_render(  ) { 

    $options = get_option( 'FF_settings' );
    ?>
    <input type='text' name='FF_settings[FF_instagram_token]' value='<?php echo $options['FF_instagram_token']; ?>'><br/>
     <a href="https://instagram.com/oauth/authorize/?client_id=257e42116b554640a1d842f96c7bec73&redirect_uri=<?php echo network_home_url();?>/wp-admin/options-general.php?page=social_media&response_type=token">Click here to get Access Token</a>
    <?php

}





function FF_settings_section_callback(  ) { 

    echo __( 'The only one that requires authentication is Instagram', 'uwd' );

}


function FF_options_page(  ) { 

    ?>
    <form action='options.php' method='post'>
        
        <h2>Social Media</h2>
        
        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>
        
    </form>
    <?php

}

?>