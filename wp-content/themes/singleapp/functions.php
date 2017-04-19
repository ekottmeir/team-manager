<?php
/**
 * SingleApp functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

if ( ! function_exists( 'singleapp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function singleapp_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on SingleApp, use a find and replace
	 * to change 'singleapp' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'singleapp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );

	// Adds Support for Custom Logo Introduced in WordPress 4.5
	add_theme_support( 'custom-logo',
		array(
    		'flex-width' => true,
    		'flex-height' => true,
    	)
    );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'singleapp-slider-thumb', 332, 583, true );
	add_image_size( 'singleapp-overview-thumb', 446,502, true );
	add_image_size( 'singleapp-overview-thumbs', 278,450, true );
	add_image_size( 'singleapp-review-thumb', 106, 106, true );
	add_image_size( 'singleapp-feature-thumb', 70, 70, true );
	add_image_size( 'singleapp-post-thumbnail', 770, 400, true );
	add_image_size( 'singleapp-archive-thumbnail', 220,230, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'singleapp' ),
		'singleapp' => esc_html__( 'Front Page', 'singleapp' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'singleapp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	// Set up the WordPress core custom header image.
	add_theme_support( 'custom-header', apply_filters( 'singleapp_custom_header_args', array(
		'default-image'          => '',
		'header-text'          	 => '',
		'default-text-color'     => '',
		'width'                  => 1920,
		'height'                 => 1000,
		'flex-height'            => true,
		'wp-head-callback'       => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'singleapp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function singleapp_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'singleapp_content_width', 640 );

}

add_action( 'after_setup_theme', 'singleapp_content_width', 0 );

if ( ! function_exists( 'singleapp_fonts_url' ) ) :
/**
 * Register Google fonts for singleapp.
 *
 * Create your own singleapp_fonts_url() function to override in a child theme.
 *
 * @return string Google fonts URL for the theme.
 */
function singleapp_fonts_url() {
  $fonts_url = '';
  $fonts = array();
  $subsets = 'latin,latin-ext';
  // applying the translators for the Google Fonts used
  /* Translators: If there are characters in your language that are not
   * supported by Roboto, translate this to 'off'. Do not translate
   * into your own language.
   */
  if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'singleapp' ) ) {
     $fonts[] = 'Roboto:400,300,500,700,400italic';
  }

  // ready to enqueue Google Font
  if ( $fonts ) {
     $fonts_url = add_query_arg( array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
     ), '//fonts.googleapis.com/css' );
  }
  return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */

function singleapp_scripts() {
	// use of enqueued google fonts
	wp_enqueue_style( 'singleapp-google-fonts', singleapp_fonts_url(), array(), null );

	//Register style font-awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', false, '4.6.3' );

	wp_enqueue_style( 'singleapp-style', get_stylesheet_uri() );

	if ( get_theme_mod('singleapp_wow_enable', 0) !== 1 && singleapp_theme_style() == 'onepage' ) {

		//Register style animate
	    wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', false, '' );

	    //Register scripts wow
	    wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js', array( 'jquery' ), '', true );
	}
	if ( is_front_page() ) {
		//Register scripts bxslider
		wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ), '4.1.2', true );
	}

	if ( singleapp_theme_style() == 'onepage' ) {

	    //Register scripts sticky
	  	wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), '1.0.2', true );
	}

	if ( singleapp_theme_style() == 'fullpage' ) {
	  	//Register jqury.fullpage.min
	    wp_enqueue_style( 'jquery-fullpage', get_template_directory_uri() . '/css/jquery.fullPage.css', false, '2.8.1' );
	    //Register
	    wp_enqueue_script( 'jquery-fullpage', get_template_directory_uri() . '/js/jquery.fullpage.min.js', array( 'jquery' ), '2.8.1', true );
	    //Register fullpage page css
	    wp_enqueue_style( 'singleapp-fullpage', get_template_directory_uri() . '/css/fullpage.css', false, '1.0.0' );
	}

	//Register scripts main
	wp_enqueue_script( 'singleapp-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'singleapp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'singleapp_scripts' );

/**
 * Add admin scripts and styles.
 */

function singleapp_admin_scripts( $hook ) {
   global $post_type;
   if( $hook == 'widgets.php' || $hook == 'customize.php' ) {

    //For image uploader
    wp_enqueue_media();

    //For color
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

   	wp_enqueue_style( 'custom_wp_admin_css', get_template_directory_uri() . '/inc/admin/css/singleapp-admin.css', false, '1.0.0' );

    wp_enqueue_script( 'singleapp-admin-scripts', get_template_directory_uri() . '/inc/admin/js/singleapp-admin.js', array( 'jquery' ), '1.0.0', true );

    }
}
add_action('admin_enqueue_scripts', 'singleapp_admin_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/singleapp.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load widgets file.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Load Metabox.
 */
require get_template_directory() . '/inc/admin/meta-boxes.php';

/**
 * Define URL Location Constants
 */
define( 'SINGLEAPP_PARENT_URL', get_template_directory_uri() );

define( 'SINGLEAPP_ADMIN_IMAGES_URL', SINGLEAPP_PARENT_URL . '/inc/admin/images' );