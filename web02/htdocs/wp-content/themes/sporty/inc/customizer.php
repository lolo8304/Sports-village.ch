<?php

/**

 * sporty Theme Customizer

 *

 * @package sporty

 * @link http://ottopress.com/tag/customizer/

 */



/**

 * Add postMessage support for site title and description for the Theme Customizer.

 *

 * @param WP_Customize_Manager $wp_customize Theme Customizer object.

 *

 */

function sporty_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transporty        = 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transporty = 'postMessage';

}

add_action( 'customize_register', 'sporty_customize_register' );



/**

 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.

 *

 * @since _s 1.2

 */

function sporty_customize_preview_js() {

	wp_enqueue_script( 'sporty_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20120827', true );

}

add_action( 'customize_preview_init', 'sporty_customize_preview_js' );



add_action ('admin_menu', 'sporty_admin');

function sporty_admin() {



}

// add settings to create various social media text areas.



add_action('customize_register', 'sporty_customize');

function sporty_customize($wp_customize) {



	$wp_customize->add_section( 'sporty_socmed_settings', array(

		'title'          => 'Social Media Settings',

		'priority'       => 35,

	) );



	$wp_customize->add_setting( 'twitter', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'twitter', array(

		'label'   => __( 'Twitter url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'facebook', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'facebook', array(

		'label'   => __( 'Facebook url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'googleplus', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'googleplus', array(

		'label'   => __( 'Google + url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'linkedin', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'linkedin', array(

		'label'   => __( 'LinkedIn url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'flickr', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'flickr', array(

		'label'   => __( 'Flickr url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'pinterest', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'pinterest', array(

		'label'   => __( 'Pinterest url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'youtube', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'youtube', array(

		'label'   => __( 'YouTube url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'vimeo', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'vimeo', array(

		'label'   => __( 'Vimeo url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'tumblr', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'tumblr', array(

		'label'   => __( 'Tumblr url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'dribble', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'dribble', array(

		'label'   => __( 'Dribble url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	$wp_customize->add_setting( 'github', array(

		'default'        => '',
		'sanitize_callback' => 'sporty_sanitize_upload',

	) );



	$wp_customize->add_control( 'github', array(

		'label'   => __( 'Github url:', 'sporty' ),

		'section' => 'sporty_socmed_settings',

		'type'    => 'text',

	) );

	

	

}