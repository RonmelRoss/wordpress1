<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Hemila for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require get_template_directory() . '/includes/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'hemila_register_required_plugins' );

function hemila_register_required_plugins() {

	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => __( 'Breadcrumb NavXT', 'hemila' ),
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
			'version'            => '6.5.0', 
		),
		array(
			'name'      => __( 'Post Thumbnail & Post List', 'hemila' ),
			'slug'      => 'post-thumbnail-post-list',
			'required'  => false,
			'version'            => '1.0.0', 
		),
		array(
			'name'      => __( 'RegistrationMagic – Custom Registration Forms and User Login', 'hemila' ),
			'slug'      => 'custom-registration-form-builder-with-submission-manager',
			'required'  => false,
			'version'   => '4.6.1.9', 
		),
		array(
			'name'      => __( 'ProfileGrid – User Profiles, Groups and Communities', 'hemila' ),
			'slug'      => 'profilegrid-user-profiles-groups-and-communities',
			'required'  => false,
			'version'   => '4.1.4', 
		),
		array(
			'name'      => __( 'Mailchimp for WordPress', 'hemila' ),
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
			'version'            => '4.8', 
		),
		
	);
	// Config Options
	$config = array(
		'id'           => 'hemila',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}
