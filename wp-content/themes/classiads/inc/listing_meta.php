<?php

	// Listing street box
	add_action( 'add_meta_boxes', 'list_street' );
	function list_street() {
	    add_meta_box( 
	        'list_street',
	        __( 'Street Address', 'myplugin_textdomain' ),
	        'list_street_content',
	        'listing',
	        'side',
	        'high'
	    );
	}

	function list_street_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$list_street = get_listing_meta( $post->ID, 'Street Address');

		echo '<label for="list_street"></label>';
		echo '<input type="text" id="list_street" name="list_street" placeholder="Enter street address here" value="';
		echo $list_street; 
		echo '">';
		
	}

	add_action( 'save_post', 'list_street_save' );
	function list_street_save( $post_id ) {		

		global $list_street;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["list_street"]))
		$list_street = $_POST['list_street'];
		update_listing_meta( $post_id, 'Street Address', $list_street );

	}

	// Listing suburb box
	add_action( 'add_meta_boxes', 'list_suburb' );
	function list_suburb() {
		add_meta_box(
		'list_suburb',
		__( 'Suburb', 'myplugin_textdomain' ),
		'list_suburb_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_suburb_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_boxee', 'myplugin_meta_box_nonceee' );
		$list_suburb = get_listing_meta( $post->ID, 'Suburb');
	
		echo '<label for="list_suburb"></label>';
		echo '<input type="text" id="list_suburb" name="list_suburb" placeholder="Enter suburb here" value="';
		echo $list_suburb;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_suburb_save' );
	function list_suburb_save( $post_id ) {
	
		global $list_suburb;
	
		if ( ! isset( $_POST['myplugin_meta_box_nonceee'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceee'], 'myplugin_meta_boxee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_suburb"]))
			$list_suburb = $_POST['list_suburb'];
		update_listing_meta( $post_id, 'Suburb', $list_suburb );
	
	}
	
	// Listing state box
	add_action( 'add_meta_boxes', 'list_state' );
	function list_state() {
		add_meta_box(
		'list_state',
		__( 'State', 'myplugin_textdomain' ),
		'list_state_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_state_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_boxe', 'myplugin_meta_box_noncee' );
		$list_state = get_listing_meta( $post->ID, 'State');
	
		echo '<label for="list_state"></label>';
		echo '<input type="text" id="list_state" name="list_state" placeholder="Enter state here" value="';
		echo $list_state;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_state_save' );
	function list_state_save( $post_id ) {
	
		global $list_state;
	
		if ( ! isset( $_POST['myplugin_meta_box_noncee'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_noncee'], 'myplugin_meta_boxe' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_state"]))
			$list_state = $_POST['list_state'];
		update_listing_meta( $post_id, 'State', $list_state );
	
	}
	
	
	// Listing postcode box
	add_action( 'add_meta_boxes', 'list_postcode' );
	function list_postcode() {
		add_meta_box(
		'list_postcode',
		__( 'Post Code', 'myplugin_textdomain' ),
		'list_postcode_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_postcode_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );
		$list_postcode = get_listing_meta( $post->ID, 'Post Code');
	
		echo '<label for="list_postcode"></label>';
		echo '<input type="text" id="list_postcode" name="list_postcode" placeholder="Enter post code here" value="';
		echo $list_postcode;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_postcode_save' );
	function list_postcode_save( $post_id ) {
	
		global $list_postcode;
	
		if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_postcode"]))
			$list_postcode = $_POST['list_postcode'];
		update_listing_meta( $post_id, 'Post Code', $list_postcode );
	
	}
	
	
	// Listing phone box
	add_action( 'add_meta_boxes', 'list_phone' );
	function list_phone() {
		add_meta_box(
		'list_phone',
		__( 'Phone Number', 'myplugin_textdomain' ),
		'list_phone_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_phone_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_box1', 'myplugin_meta_box_nonce1' );
		$list_phone = get_listing_meta( $post->ID, 'Phone Number');
	
		echo '<label for="list_phone"></label>';
		echo '<input type="text" id="list_phone" name="list_phone" placeholder="Enter phone number here" value="';
		echo $list_phone;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_phone_save' );
	function list_phone_save( $post_id ) {
	
		global $list_phone;
	
		if ( ! isset( $_POST['myplugin_meta_box_nonce1'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce1'], 'myplugin_meta_box1' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_phone"]))
			$list_phone = $_POST['list_phone'];
		update_listing_meta( $post_id, 'Phone Number', $list_phone );
	
	}
	
	// Listing email box
	add_action( 'add_meta_boxes', 'list_email' );
	function list_email() {
		add_meta_box(
		'list_email',
		__( 'Email Address', 'myplugin_textdomain' ),
		'list_email_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_email_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_box2', 'myplugin_meta_box_nonce2' );
		$list_email = get_listing_meta( $post->ID, 'Email Address');
	
		echo '<label for="list_email"></label>';
		echo '<input type="text" id="list_email" name="list_email" placeholder="Enter email address here" value="';
		echo $list_email;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_email_save' );
	function list_email_save( $post_id ) {
	
		global $list_email;
	
		if ( ! isset( $_POST['myplugin_meta_box_nonce2'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce2'], 'myplugin_meta_box2' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_email"]))
			$list_email = $_POST['list_email'];
		update_listing_meta( $post_id, 'Email Address', $list_email );
	
	}
	
	// Listing website box
	add_action( 'add_meta_boxes', 'list_website' );
	function list_website() {
		add_meta_box(
		'list_website',
		__( 'Website Address', 'myplugin_textdomain' ),
		'list_website_content',
		'listing',
		'side',
		'high'
				);
	}
	
	function list_website_content( $post ) {
		error_log($post->ID);
		wp_nonce_field( 'myplugin_meta_box3', 'myplugin_meta_box_nonce3' );
		$list_website = get_listing_meta( $post->ID, 'Website address');
	
		echo '<label for="list_website"></label>';
		echo '<input type="text" id="list_website" name="list_website" placeholder="Enter website address here" value="';
		echo $list_website;
		echo '">';
	
	}
	
	add_action( 'save_post', 'list_website_save' );
	function list_website_save( $post_id ) {
	
		global $list_website;
	
		if ( ! isset( $_POST['myplugin_meta_box_nonce3'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce3'], 'myplugin_meta_box3' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if(isset($_POST["list_website"]))
			$list_website = $_POST['list_website'];
		update_listing_meta( $post_id, 'Website Address', $list_website );
	
	}
	
	
	
	
	
?>
