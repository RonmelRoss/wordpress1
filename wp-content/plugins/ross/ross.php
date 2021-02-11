<?php
/**
 * Plugin Name: Ross Plugin
 * Description: This is my first plugin.
 * Author: RR
 * Version: 1.0.0
 **/

	function my_header_function() {
		$header_text = '<h1>My Header</h1>';
		return $header_text;
	}
	add_shortcode('my_header', 'my_header_function');

	function my_admin_menu_option() {
		add_menu_page('Header & Footer Scripts', 'Site Scripts', 'manage_options', 'my-admin-menu', 'my_admin_scripts_page', '', 200);
	}
	add_action('admin_menu', 'my_admin_menu_option');

	function my_admin_scripts_page() {

		if(array_key_exists('submit_scripts_update', $_POST)) {
			update_option('my_admin_header_scripts', $_POST['header_scripts']);
			?>
			<div id="setting-error-settings-updated" class="updated settings-error notice is-dismissible">Settings Updated!</div>
			<?php
		}

		$header_scripts = get_option('my_admin_header_scripts', 'none');

		?>
		<div class="wrap">
			<h2>Update Header & Footer Scripts</h2>
			<form method="post" action="">		
			<label for="header_scripts">Header Scripts</label>
			<textarea name="header_scripts" class="large-text"><?php print $header_scripts; ?></textarea>
			<input type="submit" name="submit_scripts_update" class="button button-primary" value="Update">
			</form>
		<div>
		<?php
	}

	function my_admin_display_header_scripts() {
		$header_scripts = get_option('my_admin_header_scripts', 'none');
		print $header_scripts;
	}
	add_action('wp_head', 'my_admin_display_header_scripts');
		
?>
