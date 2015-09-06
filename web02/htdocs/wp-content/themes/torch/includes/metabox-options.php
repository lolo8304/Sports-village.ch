<?php

/**
 * Calls the class on the post edit screen.
 */
function torch_call_metaboxClass() {
    new torch_metaboxClass();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'torch_call_metaboxClass' );
    add_action( 'load-post-new.php', 'torch_call_metaboxClass' );
}

/** 
 * The Class.
 */
class torch_metaboxClass {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'torch_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'torch_save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function torch_add_meta_box( $post_type ) {
            $post_types = array('post', 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'some_meta_box_name'
			,__( 'Torch Metabox Options', 'torch' )
			,array( $this, 'torch_render_meta_box_content' )
			,$post_type
			,'advanced'
			,'high'
		);
            }
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function torch_save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['torch_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['torch_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'torch_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$show_breadcrumb              = sanitize_text_field( $_POST['torch_show_breadcrumb'] );
		$torch_right_sidebar          = sanitize_text_field( $_POST['torch_layout'] );

		

		// Update the meta field.
		update_post_meta( $post_id, '_torch_show_breadcrumb', $show_breadcrumb );
		update_post_meta( $post_id, '_torch_layout', $torch_right_sidebar );
	
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function torch_render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'torch_inner_custom_box', 'torch_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
	    $show_breadcrumb = get_post_meta( $post->ID, '_torch_show_breadcrumb', true );
		$torch_layout      = get_post_meta( $post->ID, '_torch_layout', true );
		$select_y = "";
		$select_n = "";
		if($show_breadcrumb == "yes" || $show_breadcrumb == ""){$select_y = 'selected="selected"';}else{$select_n = 'selected="selected"';}

		// Display the form, using the current value.
		echo '<p class="meta-options"><label for="torch_show_breadcrumb"  style="display: inline-block;width: 150px;">';
		_e( 'Show Breadcrumb :', 'torch' );
		echo '</label> ';
		echo '<select name="torch_show_breadcrumb" id="torch_show_breadcrumb"><option '.$select_y.' value="yes">'.__("Yes","torch").'</option><option '.$select_n .' value="no">'.__("No","torch").'</option></select></p>';
		

		
		$torch_layout      = get_post_meta( $post->ID, '_torch_layout', true );
		$select_none = $torch_layout== 'none'?'selected="selected"':'';
		$select_left = $torch_layout== 'left'?'selected="selected"':'';
		$select_right = $torch_layout== 'right'?'selected="selected"':'';
		$select_both = $torch_layout== 'both'?'selected="selected"':'';
		
		echo '<p class="meta-options"><label for="torch_layout"  style="display: inline-block;width: 150px;">';
		_e( 'Choose Sidebar Layout :', 'torch' );
		echo '</label> ';
		echo '<select name="torch_layout" id="torch_layout">
		<option  value="right" '.$select_right.'>'.__("right","torch").'</option>
		<option  value="left" '.$select_left.'>'.__("left","torch").'</option>
		<option  value="both" '.$select_both.'>'.__("both","torch").'</option>
		<option  value="none" '.$select_none.'>'.__("none","torch").'</option>
		</select></p>';
		
		
		
	}
}