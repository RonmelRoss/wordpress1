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
?>
