<?php 

/* banner settings */

function content_settings_api_init() {
	// Add the section to reading settings so we can add our
	// fields to it
	add_settings_section(
			'content_setting_section',
			'Overwater Bungalows Site Text',
			'content_setting_section_callback_function',
			'general'
	);

	// Add the field with the names and function to use for our new
	// settings, put it in our new section
	add_settings_field(
			'conditions_apply_content',
			'Conditions Apply Content',
			'conditions_apply_content_callback_function',
			'general',
			'content_setting_section'
	);

	add_settings_field(
			'footer_content',
			'Footer Content',
			'footer_content_callback_function',
			'general',
			'content_setting_section'
	);

	// Register our setting so that $_POST handling is done for us and
	// our callback function just has to echo the <input>
	register_setting( 'general', 'conditions_apply_content' );
	register_setting( 'general', 'footer_content' );
} // eg_settings_api_init()

add_action( 'admin_init', 'content_settings_api_init' );


// ------------------------------------------------------------------
// Settings section callback function
// ------------------------------------------------------------------
//
// This function is needed if we added a new section. This function
// will be run at the start of our section
//

function content_setting_section_callback_function() {
	echo '<p>Enter content settings below</p>';
}

// ------------------------------------------------------------------
// Callback function for our example setting
// ------------------------------------------------------------------
//
// creates a checkbox true/false option. Other types are surely possible
//

function conditions_apply_content_callback_function() {
	wp_editor( get_option("conditions_apply_content"), "conditions_apply_content" );
}

function footer_content_callback_function() {
	wp_editor( get_option("footer_content"), "footer_content" );
}



?>