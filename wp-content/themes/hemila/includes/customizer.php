<?php
/**
 * Hemila Theme Customizer
 *
 * @package hemila
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hemila_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'hemila_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'hemila_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'hemila_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hemila_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hemila_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hemila_customize_preview_js() {
	wp_enqueue_script( 'hemila-customizer', get_template_directory_uri() . '/resource/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'hemila_customize_preview_js' );


// Load customizer required panels

// Sanitize
require trailingslashit( get_template_directory() ) . '/includes/sanitize.php'; 

// Pro Version
require_once trailingslashit( get_template_directory() ) . '/includes/upgrade-to-pro/control.php';


add_action( 'customize_register', 'hemila_register_customizer_front' );
function hemila_register_customizer_front( $wp_customize ) {


$wp_customize->add_panel( 'hemila_front_option', array(
	'priority'               => 1,
	'capability'             => 'edit_theme_options',
	'title'                  => __( 'Hemila: Theme Settings', 'hemila' ),
	'description'            => __( 'Hemila awesome theme options', 'hemila' ),
) );  

// Load Options
require trailingslashit( get_template_directory() ) . '/includes/hemila-customizer/customize-header.php';
require trailingslashit( get_template_directory() ) . '/includes/hemila-customizer/customize-post-slider.php';
require trailingslashit( get_template_directory() ) . '/includes/hemila-customizer/customize-top-grid-post.php';
require trailingslashit( get_template_directory() ) . '/includes/hemila-customizer/customize-breadcrumb.php';

// Upgrade to Pro
$wp_customize->register_section_type( 'hemila_Customize_Section_Upsell' );
// Register sections.
$wp_customize->add_section(
	new hemila_Customize_Section_Upsell(
		$wp_customize,
		'theme_upsell',
		array(
			'title'    => esc_html__( 'Now Available Hemila Pro ', 'hemila' ),
			'pro_text' => esc_html__( 'Buy Now', 'hemila' ),
			'pro_url'  => 'https://sitebland.com/product/hemila-pro/',
			'priority' => 1,
		)
	)
);
// Hemila Customizer Scripts
function hemila_customizer_control_scripts() {
	wp_enqueue_script( 'hemila-customize-controls', get_template_directory_uri() . '/includes/upgrade-to-pro/customize-controls.js', array( 'customize-controls' ) );
	wp_enqueue_style( 'hemila-customize-controls', get_template_directory_uri() . '/includes/upgrade-to-pro/customize-controls.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'hemila_customizer_control_scripts', 0 );

}