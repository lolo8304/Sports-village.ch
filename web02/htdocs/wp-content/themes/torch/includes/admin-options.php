<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */

 function optionsframework_option_name() {

    $themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	return $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Background Defaults
	$page_background = array(
		'color' => '',
		'image' => '',
		'repeat' => 'no-repeat',
		'position' => 'top left',
		'attachment'=>'fixed' );

	$options      = array();
	$social_icons = array('fa fa-facebook'=>'facebook',
						  'fa fa-twitter'=>'twitter',
						  'fa fa-youtube'=>'youtube',
						  'fa fa-google-plus'=>'google plus',
						  'fa fa-flickr'=>'flickr',
						  'fa fa-linkedin'=>'linkedin',
						  'fa fa-pinterest'=>'pinterest',
						  'fa fa-tumblr'=>'tumblr',
						  'fa fa-digg'=>'digg',
						  'fa fa-rss'=>'rss',
						 
						  );
   // General
	$options[] = array(
		'name' => __('General Options', 'torch'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Upload Logo', 'torch'),
		'id' => 'logo',
		'std' => '',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Favicon', 'torch'),
		'desc' => __('An icon associated with a URL that is variously displayed, as in a browser\'s address bar or next to the site name in a bookmark list. Learn more about <a href="'.esc_url("http://en.wikipedia.org/wiki/Favicon").'" target="_blank">Favicon</a>', 'torch'),
		'id' => 'favicon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Global Color', 'torch'),
		'id' => 'global_color',
		'std' => '#19cbcf',
		'type' => 'color');
	
	$options[] = array(
		'name' => __('404 Page Content', 'torch'),
		'id' => 'page_404_content',
		'std' => '<i class="fa fa-frown-o"></i>
		<p><strong>OOPS!</strong> Can\'t find the page.</p>',
		'type' => 'editor');
		
	$options[] = array(
		'name' => __('Custom CSS', 'torch'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'torch'),
		'id' => 'custom_css',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');

        // Home Page
	    $options[] = array(
		'name' => __('Home Page', 'torch'),
		'type' => 'heading');
		
		 $options[] = array(
		'name' => __('Enable Featured Homepage', 'torch'),
		'desc' => __('Active featured homepage Layout.  The standardized way of creating Static Front Pages: <a href="'.esc_url('http://codex.wordpress.org/Creating_a_Static_Front_Page').'" target="_blank">Creating a Static Front Page</a>', 'torch'),
		'id' => 'enable_home_page',
		'std' => '0',
		'type' => 'checkbox');
		
		 $options[] = array(
		'name' => __('NOTE:', 'torch'),
		'desc' => sprintf(__('All sections in the homepage are widgets, so, go to Appearance-><a href="%s">Widgets</a> to set the sections content.', 'torch'),admin_url("widgets.php")),
		'type' => 'info');
		
		
		// FOOTER
	    $options[] = array(
		'name' => __('Footer', 'torch'),
		'type' => 'heading');
	
        for($i=0;$i<10;$i++){
			
	    $options[] = array(
		"name" => sprintf(__('Social Icon #%s', 'torch'),($i+1)),
		"id" => "social_icon_".$i,
		"std" => "",
		"type" => "select",
		"options" => $social_icons );
		
		$options[] = array('name' => sprintf(__('Social Link #%s', 'torch'),($i+1)),'id' => 'social_link_'.$i,'type' => 'text');	
		}
		
		
		
		// Slider
		$options[] = array(
		'name' => __('Home Page Slider', 'torch'),
		'type' => 'heading');
		
		//HOME PAGE SLIDER
		$options[] = array('name' => __('Slideshow', 'torch'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'torch'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'torch'),'id' => 'torch_slide_image_1','type' => 'upload','std'=>TORCH_THEME_BASE_URL.'/images/banner-11.jpg');
		$options[] = array('name' => __('Text', 'torch'),'id' => 'torch_slide_text_1','type' => 'editor','std'=>'<h1>Lorem ipsum dolor sit amet</h1><p>consectetur adipiscing elit. Donec eu risus ut eros luctus viverra. Praesent tincidunt, leo sit amet bibendum semper, risus sem consectetur tellus, a pretium augue massa eu felis. Praesent metus lacus, mattis in vehicula in, tempor vel eros. consectetur adipiscing elit. Donec eu risus ut eros luctus viverra. Praesent tincidunt, leo sit amet bibendum semper, risus sem consectetur tellus, a pretium augue massa eu felis. Praesent metus lacus, mattis in vehicula in, tempor vel eros.</p>');
		$options[] = array('name' => __('Button Link', 'torch'),'id' => 'torch_slide_link_1','type' => 'text','std'=>'#');
		$options[] = array('name' => __('Button Text', 'torch'),'id' => 'torch_slide_btn_text_1','type' => 'text','std'=>'Tell Me More');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'torch'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'torch'),'id' => 'torch_slide_image_2','type' => 'upload','std'=>TORCH_THEME_BASE_URL.'/images/banner-21.jpg');
		$options[] = array('name' => __('Text', 'torch'),'id' => 'torch_slide_text_2','type' => 'editor','std'=>'<h1>Lorem ipsum dolor sit amet</h1><p>consectetur adipiscing elit. Donec eu risus ut eros luctus viverra. Praesent tincidunt, leo sit amet bibendum semper, risus sem consectetur tellus, a pretium augue massa eu felis. Praesent metus lacus, mattis in vehicula in, tempor vel eros.</p>');
		$options[] = array('name' => __('Button Link', 'torch'),'id' => 'torch_slide_link_2','type' => 'text','std'=>'#');
		$options[] = array('name' => __('Button Text', 'torch'),'id' => 'torch_slide_btn_text_2','type' => 'text','std'=>'Tell Me More');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'torch'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'torch'),'id' => 'torch_slide_image_3','type' => 'upload','std'=>'');
		$options[] = array('name' => __('Text', 'torch'),'id' => 'torch_slide_text_3','type' => 'editor','std'=>'');
		$options[] = array('name' => __('Button Link', 'torch'),'id' => 'torch_slide_link_3','type' => 'text');
		$options[] = array('name' => __('Button Text', 'torch'),'id' => 'torch_slide_btn_text_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'torch'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'torch'),'id' => 'torch_slide_image_4','type' => 'upload','std'=>'');
		$options[] = array('name' => __('Text', 'torch'),'id' => 'torch_slide_text_4','type' => 'editor','std'=>'');
		$options[] = array('name' => __('Button Link', 'torch'),'id' => 'torch_slide_link_4','type' => 'text');
		$options[] = array('name' => __('Button Text', 'torch'),'id' => 'torch_slide_btn_text_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'torch'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'torch'),'id' => 'torch_slide_image_5','type' => 'upload');
		$options[] = array('name' => __('Text', 'torch'),'id' => 'torch_slide_text_5','type' => 'editor');
		$options[] = array('name' => __('Button Link', 'torch'),'id' => 'torch_slide_link_5','type' => 'text');
		$options[] = array('name' => __('Button Text', 'torch'),'id' => 'torch_slide_btn_text_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		

		
		$options[] = array(
		'name' => __('Slide Time', 'torch'),
		'id' => 'slide_time',
		'std' => '5000',
		'desc'=>__('Milliseconds between the end of the sliding effect and the start of the nex one.','torch'),
		'type' => 'text');		
		

		
		//END HOME PAGE SLIDER
		
	return $options;
}

