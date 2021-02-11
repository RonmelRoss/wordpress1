<?php
/**
 * hemila functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hemila
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'hemila_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hemila_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on hemila, use a find and replace
		 * to change 'hemila' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hemila', get_template_directory() . '/languages' );

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
		
		// Image Size
		add_image_size('hemila-slider-thumb', 570, 370, true);
		add_image_size('hemila-top-grid-thumb', 370, 232, true);
		add_image_size('hemila-blog-thumb', 500, 338, true);
		add_image_size('hemila-blog-single-thumb', 770, 380, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-2' => esc_html__( 'Top Menu', 'hemila' ),
				'menu-1' => esc_html__( 'Primary', 'hemila' ),
			)
		);

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
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'hemila_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		
		/*
		* Enable support for wide alignment class for Gutenberg blocks.
		*/
		add_theme_support( 'align-wide' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		
		add_theme_support( 'post-formats', array('video', 'gallery') );
		
	}
endif;
add_action( 'after_setup_theme', 'hemila_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'content_width', 640 );
}
add_action( 'after_setup_theme', 'content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hemila_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Main', 'hemila' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hemila' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Right', 'hemila' ),
			'id'            => 'hemila-header-right',
			'description'   => esc_html__( 'Add Ads code or add any widget in here.', 'hemila' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'hemila' ),
		'id'            => 'hemila_footer_1',
		'description'   => esc_html__( 'Add footer widget here.', 'hemila' ),
		'before_widget' => '<div id="%1$s" class="single-widget lists widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'hemila' ),
		'id'            => 'hemila_footer_2',
		'description'   => esc_html__( 'Add footer widget here.', 'hemila' ),
		'before_widget' => '<div id="%1$s" class="single-widget lists widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'hemila' ),
		'id'            => 'hemila_footer_3',
		'description'   => esc_html__( 'Add footer widget here.', 'hemila' ),
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'hemila_widgets_init' );


function hemila_wpdocs_custom_excerpt_length( $length ) {
    $excerptlength = absint(get_theme_mod('hemila_post_excerpt',22));
    return $excerptlength;
}
add_filter( 'excerpt_length', 'hemila_wpdocs_custom_excerpt_length', 999 );


/**
 * Enqueue scripts and styles.
 */
function hemila_scripts() {
	wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css?family=Raleway:ital,wght@0,400;0,500;0,600;0,700;0,900;1,400;1,500&display=swap');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/resource/css/bootstrap.min.css', array(), '4.4.1' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/resource/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/resource/css/normalize.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'slick-slider', get_template_directory_uri() . '/resource/css/slick-slider.min.css', array(), '1.6.0' );
	wp_enqueue_style( 'hemila-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'hemila-responsive', get_template_directory_uri() . '/resource/css/responsive.css', array(), '1.0' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/resource/js/bootstrap.min.js', array('jquery'), '4.4.1', true );
	wp_enqueue_script( 'slick-slider-js', get_template_directory_uri() . '/resource/js/slick.min.js', array('jquery'), '1.6.0', true );
	wp_enqueue_script( 'hemila-navigation', get_template_directory_uri() . '/resource/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'keyboard-nav', get_template_directory_uri() . '/resource/js/keyboard-nav.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'skip-link-js', get_template_directory_uri() . '/resource/js/keyboard-nav.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'active', get_template_directory_uri() . '/resource/js/active.js', array('jquery'), '1.0.0', true );	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hemila_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/template-functions.php';

/**
 * Load TGM plugins for required plugins.
 */
require get_template_directory() . '/includes/tgm/required-plugins.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';