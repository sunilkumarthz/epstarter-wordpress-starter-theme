<?php
/**
 * EPStarter setup class
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage epstarter
 * @since 1.0.0
 */

namespace epstarter;

class Setup_Theme{

  public static function run(){

    add_action( 'after_setup_theme', array( get_called_class(), 'add_support' ) );
    add_action( 'after_setup_theme', array( get_called_class(), 'register_menu' ) );
    add_action( 'wp_enqueue_scripts', array( get_called_class(), 'enqueue_scripts' ) );
    add_filter( 'wp_resource_hints', array( get_called_class(), 'epstarter_resource_hints' ), 10, 2 );

  }

  public static function add_support(){

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'epstarter', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

    // Add theme support for post formats. Available formats : https://codex.wordpress.org/Post_Formats
    // add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

		// Add custom editor font sizes.
		// add_theme_support(
		// 	'editor-font-sizes',
		// 	array(
		// 		array(
		// 			'name'      => __( 'Small', 'epstarter' ),
		// 			'shortName' => __( 'S', 'epstarter' ),
		// 			'size'      => 19.5,
		// 			'slug'      => 'small',
		// 		),
		// 		array(
		// 			'name'      => __( 'Normal', 'epstarter' ),
		// 			'shortName' => __( 'M', 'epstarter' ),
		// 			'size'      => 22,
		// 			'slug'      => 'normal',
		// 		),
		// 		array(
		// 			'name'      => __( 'Large', 'epstarter' ),
		// 			'shortName' => __( 'L', 'epstarter' ),
		// 			'size'      => 36.5,
		// 			'slug'      => 'large',
		// 		),
		// 		array(
		// 			'name'      => __( 'Huge', 'epstarter' ),
		// 			'shortName' => __( 'XL', 'epstarter' ),
		// 			'size'      => 49.5,
		// 			'slug'      => 'huge',
		// 		),
		// 	)
		// );
    //
		// // Editor color palette.
		// add_theme_support(
		// 	'editor-color-palette',
		// 	array(
		// 		array(
		// 			'name'  => __( 'Primary', 'epstarter' ),
		// 			'slug'  => 'primary',
		// 			'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
		// 		),
		// 		array(
		// 			'name'  => __( 'Secondary', 'epstarter' ),
		// 			'slug'  => 'secondary',
		// 			'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
		// 		),
		// 		array(
		// 			'name'  => __( 'Dark Gray', 'epstarter' ),
		// 			'slug'  => 'dark-gray',
		// 			'color' => '#111',
		// 		),
		// 		array(
		// 			'name'  => __( 'Light Gray', 'epstarter' ),
		// 			'slug'  => 'light-gray',
		// 			'color' => '#767676',
		// 		),
		// 		array(
		// 			'name'  => __( 'White', 'epstarter' ),
		// 			'slug'  => 'white',
		// 			'color' => '#FFF',
		// 		),
		// 	)
		// );


  }

  public static function register_menu(){


    		// This theme uses wp_nav_menu() in two locations.
    		register_nav_menus(
    			array(
    				'primary' => __( 'Primary', 'epstarter' ),
    				'footer' => __( 'Footer Menu', 'epstarter' )
    			)
    		);

  }

  public static function enqueue_scripts(){

    $theme_version = wp_get_theme()->get( 'Version' );
    $theme_name = str_replace( " ", "-", strtolower( wp_get_theme()->Name ) ) ;
    $css_dir = get_template_directory_uri() . '/assets/css/';
    $js_dir = get_template_directory_uri() . '/assets/js/';

  	// Add custom fonts, used in the main stylesheet.
  	wp_enqueue_style( $theme_name . '-fonts', self::epstarter_fonts_url(), array(), null );
    wp_enqueue_style( $theme_name . '-style', get_stylesheet_uri(), array(), $theme_version );
    wp_enqueue_style( 'bootstrap4', $css_dir . 'bootstrap.min.css', array(), '4.2.1', 'all' );
    wp_enqueue_style( 'fontawesome5', $css_dir . 'fontawesome.min.css', array(), '5.6.3', 'all' );
    wp_enqueue_style( $theme_name . '-theme', $css_dir . 'theme.min.css', array(), $theme_version, 'all' );

  	// Load the html5 shiv.
  	wp_enqueue_script( 'html5',  $js_dir . 'html5.min.js', array(), '3.7.3' );
  	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

    wp_enqueue_script( $theme_name . '-skip-link-focus-fix', $js_dir . 'skip-link-focus-fix.min.js', array(), '20151215', true );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-bundle', $js_dir . 'bootstrap.bundle.min.js', array( 'jquery' ), '4.2.1', true );
    wp_enqueue_script( $theme_name . 'scripts', $js_dir . 'theme.min.js', array( 'jquery' ), $theme_version, true );

  	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
  		wp_enqueue_script( 'comment-reply' );
  	}

  }

  /**
   * Register custom fonts.
   */
  public static function epstarter_fonts_url() {

  	$fonts_url = '';

  	/*
  	 * Translators: If there are characters in your language that are not
  	 * supported by Libre Franklin, translate this to 'off'. Do not translate
  	 * into your own language.
  	 */
  	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'epstarter' );

  	if ( 'off' !== $libre_franklin ) {
  		$font_families = array();

  		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

  		$query_args = array(
  			'family' => urlencode( implode( '|', $font_families ) ),
  			'subset' => urlencode( 'latin,latin-ext' ),
  		);

  		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
  	}

  	return esc_url_raw( $fonts_url );

  }



  /**
   * Add preconnect for Google Fonts.
   *
   * @since Twenty Seventeen 1.0
   *
   * @param array  $urls           URLs to print for resource hints.
   * @param string $relation_type  The relation type the URLs are printed.
   * @return array $urls           URLs to print for resource hints.
   */
  public static function epstarter_resource_hints( $urls, $relation_type ) {

    $theme_name = str_replace( " ", "-", strtolower( wp_get_theme()->Name ) ) ;

  	if ( wp_style_is( $theme_name . '-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
  		$urls[] = array(
  			'href' => 'https://fonts.gstatic.com',
  			'crossorigin',
  		);
  	}

  	return $urls;
  }


}

Setup_Theme::run();

?>
