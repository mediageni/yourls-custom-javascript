<?php
/*
Plugin Name: Custom Javascript
Plugin URI: http://scriptgeni.com/
Description: A plugin administration page to add custom javascript to Yourls
Version: 1.0
Author: ScriptGeni
Author URI: http://scriptgeni.com
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();


// Add the inline style
yourls_add_action( 'html_footer', 'yourls_custom_javascript' );

function yourls_custom_javascript() {
$custom_js_option = yourls_get_option( 'custom_js_option' );
	echo <<<JS

<script>$custom_js_option</script>

JS;
}





// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'yourls_custom_js' );
function yourls_custom_js() {
	yourls_register_plugin_page( 'custom_js_page', 'Custom Javascript Settings', 'yourls_custom_js_do_page' );
	// parameters: page slug, page title, and function that will display the page itself
}

// Display admin page
function yourls_custom_js_do_page() {

	// Check if a form was submitted
	if( isset( $_POST['custom_js_option'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'custom_js_page' );
		
		// Process form
		yourls_custom_js_update_option();
	}




	// Get value from database
	$custom_js_option = yourls_get_option( 'custom_js_option' );

	
	// Create nonce
	$nonce = yourls_create_nonce( 'custom_js_page' );

	echo <<<HTML
		<h2>Javascript code</h2>
		<p>Add extra JS code</p>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><textarea name="custom_js_option">$custom_js_option</textarea></p>
		<p><input type="submit" value="Update Javascript" /></p>
		</form>


HTML;
}

// Update option in database
function yourls_custom_js_update_option() {

	$custom_js = $_POST['custom_js_option'];
	
	// Update value in database
	yourls_update_option( 'custom_js_option', $custom_js );


}