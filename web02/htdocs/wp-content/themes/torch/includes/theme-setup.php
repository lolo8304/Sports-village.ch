<?php


function torch_tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

add_action('pre_get_posts', 'torch_tags_support_query');

function torch_setup(){
	global $content_width;
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('torch', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		'default-repeat' => 'no-repeat',
        'default-text-color'     => 'fff',
		'url'                    => '',
        'width'                  => 1920,
        'height'                 => 95,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	
	register_nav_menus( array('primary' => __( 'Primary Menu', 'torch' )));
	add_editor_style("editor-style.css");
	add_image_size( 'portfolio', 800, 600 , true);  
	add_image_size( 'blog', 300, 200 , true);
	add_image_size( 'service', 128, 128 , true);
	if ( !isset( $content_width ) ) $content_width = 1170;
	
	
}

add_action( 'after_setup_theme', 'torch_setup' );


 function torch_custom_scripts(){
	 global $is_IE;
	wp_enqueue_style('torch-bootstrap',  get_template_directory_uri() .'/css/bootstrap.css', false, '4.0.3', false);
    wp_enqueue_style('torch-font-awesome',  get_template_directory_uri() .'/css/font-awesome.min.css', false, '4.0.3', false);
    wp_enqueue_style('torch-carousel',  get_template_directory_uri() .'/css/owl.carousel.css', false, '1.3.2', false);
	wp_enqueue_style( 'torch-main', get_stylesheet_uri(), array(), '1.1.8' );
	
	wp_enqueue_style('torch-scheme', get_template_directory_uri().'/css/scheme.less', false, '1.1.8', false);
	wp_enqueue_style('montserrat', esc_url('//fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:300,400,700'), false, '', false );
	
   $header_image      = get_header_image();

   $header_background = ""  ;
   $torch_custom_css = "";
	if (isset($header_image) && ! empty( $header_image )) {
	$torch_custom_css .= ".blog-list-page header{background:url(".$header_image. ") no-repeat;}\n";
	}
    if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
     $header_background  .=  ' color:#' . get_header_textcolor() . ';';
	 $torch_custom_css .=  '.header-wrapper header .name-box .site-name,.header-wrapper header .name-box .site-tagline {'.$header_background.'}';
		}
	$global_color           =  torch_options_array("global_color");
	
	if( !$global_color )
	{
		$global_color = "#19cbcf";
		}

$torch_custom_css .= '
a:active,
a:hover {
	color:'.$global_color.';
}

mark,
ins {
	background: '.$global_color.';
}

::selection {
	background:'.$global_color.';
}

::-moz-selection {
	background: '.$global_color.';
}

.search-form input[type="submit"] {
	background-color:'.$global_color.';
}

.site-nav > ul > li:hover > a {
	color:'.$global_color.';
	border-bottom-color:'.$global_color.';
}

.site-nav li > ul > li:hover > a {
	color:'.$global_color.';
}

.homepage-slider .carousel-caption button {
	background-color:'.$global_color.';
}

.homepage-slider .carousel-caption button:hover {
	background-color: darken(@color-main, 5%);
}

.homepage-slider .carousel-indicators li.active {
	border-color:'.$global_color.';
	color:'.$global_color.';
}

.service-box:hover i {
	color:'.$global_color.';
}

.service-box:hover a {
	color:'.$global_color.';
}

.slogan-box {
	border-top-color:'.$global_color.';
}

.slogan-box .btn-normal {
	background-color:'.$global_color.';
}

.slogan-box .btn-normal:hover {
	background-color: darken(@color-main, 5%);
}

.portfolio-box:hover .portfolio-box-title {
	background-color:'.$global_color.';
}

.testimonial-content {
	border-top-color:'.$global_color.';
}

.testimonial-content i {
	color:'.$global_color.';
}

.contact-form input[type="submit"] {
	background-color:'.$global_color.';
}

.contact-form input[type="submit"]:hover {
	background-color: darken(@color-main, 5%);
}

.contact-form input:focus,
.contact-form textarea:focus {
	border-color:'.$global_color.';
	color:'.$global_color.';
}

footer {
	background-color:'.$global_color.';
}

.entry-meta a:hover {
	color:'.$global_color.';
}

.entry-title-dec {
	border-bottom-color:'.$global_color.';
}

a .entry-title:hover {
	color:'.$global_color.';
}

.entry-more:hover {
	color:'.$global_color.';
}

.list-pagition a:hover {
	background-color:'.$global_color.';
}

.entry-summary a,
.entry-content a {
	color:'.$global_color.';
}

.comment-form input:focus,
.comment-form textarea:focus {
	border-color:'.$global_color.';
	color:'.$global_color.';
}

.form-submit input {
	background-color:'.$global_color.';
}

.form-submit input:hover {
	background-color: darken(@color-main, 5%);
}

.widget-box a:hover {
	color:'.$global_color.';
}

.widget-slider .carousel-indicators li {
	border-color:'.$global_color.';
}

.widget-slider .carousel-indicators li.active {
	background-color:'.$global_color.';
}

.widget-post .widget-post-box a:hover {
	color:'.$global_color.';
}

.widget-box > ul > li,
.widget-post > ul > li {
	border-right-color:'.$global_color.';
}';

	$custom_css           =  torch_options_array("custom_css");
	
	$torch_custom_css  .=  $custom_css;
	
	wp_add_inline_style( 'torch-main', $torch_custom_css );
	
	

	wp_enqueue_script( 'torch-bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', false );
	
	//wp_enqueue_script( 'torch-less', get_template_directory_uri().'/js/less.min.js', array( 'jquery' ), '1.4.2', false );
	
	wp_enqueue_script( 'torch-respond', get_template_directory_uri().'/js/respond.min.js', array( 'jquery' ), '1.4.2', false );
	wp_enqueue_script( 'torch-carousel', get_template_directory_uri().'/js/owl.carousel.min.js', array( 'jquery' ), '1.3.2', false );
	wp_enqueue_script( 'torch-modernizr', get_template_directory_uri().'/js/modernizr.custom.js', array( 'jquery' ), '2.8.2', false );
	wp_enqueue_script( 'torch-main', get_template_directory_uri().'/js/torch.js', array( 'jquery' ), '1.1.8', true );
	
	if(isset($global_color) && $global_color != ""  ){
	 wp_localize_script( 'torch-less', 'torch_js_var', array("global_color"=>$global_color));
	}
	
	if( $is_IE ) {
	wp_enqueue_script( 'torch-html5', get_template_directory_uri().'/js/html5.js', array( 'jquery' ), '', false );
	}
	
		wp_localize_script( 'torch-main', 'torch_params',  array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => TORCH_THEME_BASE_URL,
		)  );
		
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
	}

   if (!is_admin()) {
  add_action( 'wp_enqueue_scripts', 'torch_custom_scripts' );
  }




function torch_of_get_option($name, $default = false) {

	
	// Gets the unique option id
	$option_name = optionsframework_option_name();
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
		
	}
}

function torch_of_get_options($default = false) {
	
	
	// Gets the unique option id
	$option_name = optionsframework_option_name();
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options) ) {
		return $options;
	} else {
		return $default;
	}
}

global $torch_options;
$torch_options = torch_of_get_options();


function torch_options_array($name){
	global $torch_options;
	if(isset($torch_options[$name]))
	return $torch_options[$name];
	else
	return "";
}


/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'torch_optionsframework_custom_scripts');

function torch_optionsframework_custom_scripts() { 

}

add_filter('options_framework_location','torch_options_framework_location_override');

function torch_options_framework_location_override() {
	return array('includes/admin-options.php');
}

function torch_optionscheck_options_menu_params( $menu ) {
	
	$menu['page_title'] = __( 'Torch Options', 'torch');
	$menu['menu_title'] = __( 'Torch Options', 'torch');
	$menu['menu_slug'] = 'torch-options';
	return $menu;
}
add_filter( 'optionsframework_menu', 'torch_optionscheck_options_menu_params' );


add_action('admin_init','torch_optionscheck_change_santiziation', 100);
function torch_optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'torch_custom_sanitize_textarea' );
}
function torch_custom_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
      "src" => array(),
      "type" => array(),
      "allowfullscreen" => array(),
      "allowscriptaccess" => array(),
      "height" => array(),
      "width" => array()
      );
      $custom_allowedtags["script"] = array();
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}