<?php
defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: Tab Slide Pro
Plugin URI: http://store.zoranc.co
Description: Slide your target page into and out of the visible page with this WordPress plugin. No coding skills are required to implement this functionality on your WordPress site. This is the premium version of Tab Slide. Multiple instances - infinite possibilities.
Version: 2.1.4
Author: Zoran C.
Author URI: http://zoranc.co/
License Url: http://store.zoranc.co/licence
*/
// Define contants
define( 'TAB_SLIDE_PRO_VERSION' , '2.1.4' );
define( 'TAB_SLIDE_PRO_ROOT' , dirname(__FILE__) );
define( 'TAB_SLIDE_PRO_FILE_PATH' , TAB_SLIDE_PRO_ROOT . '/' . basename(__FILE__) );
define( 'TAB_SLIDE_PRO_URL' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
define( 'TAB_SLIDE_PRO_SETTINGS_PAGE' , 'admin.php?page=tab-slide-pro' );

// Include necessary files, including the path in which to search to avoid conflicts
include_once( TAB_SLIDE_PRO_ROOT . '/includes/upgrade.php' );

$plugin = plugin_basename(__FILE__); 

register_uninstall_hook( __FILE__, array( 'tab_slide_pro', 'uninstall_plugin' ) );

class Tab_Slide_Pro {
	// Unique identifier added as a prefix to all options in the db
	var $options_group = 'tab_slide_pro_';

	var $plugin_options = array(
		"version" => 0,
		"api_key" => "",
		"instances" => array()
	);

	var $active_instances = array();
	var $active_shortcodes = array();
	
  var $hook_html = array(
			'filter'=> array(
				'the_content' => '',
				'the_excerpt' => ''
				),
			'action' => array(
				'wp_footer'   => '', 
				'wp_head'     => ''
			)
		); 
	public function __construct() {
	  // Translation files
		load_plugin_textdomain( 'tab-slide-pro', null, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
	  // Following plugin options are written to the wp database upon plugin activation
		$this->load_default_themes();
		
	  // Sort out the tab slide options
		$this->load_options();
		
	  // Admin Init
		if( is_admin() ) {
			add_filter(    'plugin_action_links',		        array( $this, 'tab_slide_settings_link' ), 10, 2 );			      
			add_action(    'admin_init',                    array( $this, 'admin_init' ) );
			add_action(    'init',                          array( $this, 'admin_menu_init' ) );
			add_action(    'admin_enqueue_scripts',         array( $this, 'add_admin_scripts' ) );
			add_action(    'wp_ajax_settings_ajax_handler', array( $this, 'settings_ajax_handler' ) );
			add_action(    'save_tab_slide_settings',       array( $this, 'generate_instance_css' ), 10, 1 );
			add_action(    'init',                          array( $this, 'activate_autoupdate' ) );
    	add_filter(    'http_request_args',             array( $this, 'tsp_deactivate_wp_org_update' ), 5, 2 );
    	add_filter(    'upgrader_source_selection', 	  array( $this, 'rename_tsp_zip' ), 1, 3 );
		} else {
			add_action(    'wp',	   array( $this, 'do_init_check' ), 10 );
			add_shortcode( 'tabslide', array( $this, 'shortcode_handler' ) );
		}
		add_action( 'widgets_init',  array( $this, 'tab_slide_widgets_init' ) );
	}
  /**
   * activate_tab_slide ()
   *
   * Trigger events on plugin activation and import the free tab slide instance
   *
   * @return none
   */
	public function activate_tab_slide () {
		include_once ( TAB_SLIDE_PRO_ROOT . '/includes/import.php');
	}
  /**
   * deactivate_tab_slide ()
   *
   * Trigger events on plugin deactivation
   *
   * @return none
   */
	public function deactivate_plugin( ) {
	}
  /**
   * uninstall plugin ()
   *
   * Trigger events on plugin uninstall
   * Deleted all the related tab slide options and metadata
   *
   * @return none
   */
	public static function uninstall_plugin() {
		global $tab_slide_pro;
		$tab_slide_pro->delete_options($tab_slide_pro->plugin_options);
	}
	/**
	 * Helper function to delete a directory.
	 */
	public static function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
	    throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	    $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
	    if (is_dir($file)) {
	        self::deleteDir($file);
	    } else {
	        unlink($file);
	    }
    }
    rmdir($dirPath);
	}
	public function load_default_themes() {
		$this->plugin_options['instances'][] = json_decode(file_get_contents(TAB_SLIDE_PRO_ROOT . '/themes/default-light.json'), true);
		$this->plugin_options['instances'][] = json_decode(file_get_contents(TAB_SLIDE_PRO_ROOT . '/themes/default-dark.json'), true);
	}
  /*
   * load_options ()
   *
   * Load options for the plugin.
   * If option doesn't exist in database, it is added
   * Note: default values are stored in the $this->plugin_options array
   * Note: a prefix unique to the plugin is appended to all the options. Prefix is stored in $this->options_group
   * 
   * @return none
   */
	public function load_options() {
		$new_options = array();
		foreach($this->plugin_options as $option => $value) {
			$name = $this->get_plugin_option_fullname($option);
			$return = get_option($name);
			if($return === false) {
				add_option($name, $value);
				$new_array[$option] = $value;
				if( $option == 'instances' ) {
					foreach ( $value as $instance ) {
						$this->generate_instance_css($instance);
					}
				}
			} else {
				$new_array[$option] = $return;
			}
		}
		$this->plugin_options = $new_array;
	}
  /*
   * get_plugin_option_fullname ()
   *
   * Append the option prefix and returns the full name of the option as it is stored in the wp_options db
   *
   * @return string prefixed option name
   */
	public function get_plugin_option_fullname ( $name ) {
		return $this->options_group . $name;
	}
  /**
   * get_plugin_option ()
   *
   * Return option for the plugin specified by $name, e.g. show_on_load
   * Note: The plugin option prefix does not need to be included in $name
   *
   * @param string name of the option
   * @return option|null if not found
   */
	public function get_plugin_option ( $name ) {
		if (is_array($this->plugin_options) && $option = $this->plugin_options[$name])
			return $option;
		else 
			return null;
	}
  /**
   * update_plugin_option ()
   *	 
   * Update option for the plugin specified by $name, e.g. show_on_load
   * Note: The plugin option prefix does not need to be included in $name 
   * 
   * @param string name of the option
   * @param string value to be set
   *
   */
	function update_plugin_option( $name, $new_value ) {
		if( is_array($this->plugin_options) /*&& !empty( $this->options[$name] )*/ ) {
			$this->plugin_options[$name] = $new_value;
			update_option( $this->get_plugin_option_fullname( $name ), $new_value );
		}
	}
	function update_instance_option( $name, $new_value, $id ) {
		$all_instances = $this->plugin_options['instances'];
		$all_instances[$id][$name] = $new_value;
		$this->update_plugin_option( 'instances', $all_instances );
		return true;
	}
  /**
   * delete_options ()
   *
   * Delete all the options provided
   * Note: The plugin option prefix does not need to be included in $name 
   * 
   * @param array options to be deleted
   * @return none
   *
   */
	public function delete_options ($my_options) {
		if (!is_string($my_options)){
			foreach (array_keys($my_options) as $value) {
				$name = $this->get_plugin_option_fullname($value);
					delete_option($name);	
			}
		}
	}
	/**
	 * Validate the input from settings screen
	 */
	function tab_slide_pro_options_validate() {
		$all_opt = $this->get_plugin_option('instances');
		if ( array_key_exists( 'new_opt', $_POST ) ) { 
			$new_opt = $_POST['new_opt']; 
			foreach ( $new_opt as $id => $instance ) {
				foreach ( $instance as $option => $value) {
					if ($option == 'css') { $value = stripslashes($value); }
					$all_opt[$id][$option] = $value;
				}
			}
		}
		return $all_opt;
	}
	public function get_css_via_buffer($instance) {
		if ( ! is_array($instance) && settype($instance, "integer") ) {
			$instance = isset($this->plugin_options['instances'][$instance]) ? $this->plugin_options['instances'][$instance] : false;
		}
		ob_start();
		require('includes/css.php');
		$instance_css = ob_get_clean();
		return $instance_css;
	}
  /**
   * generate_master_css ()
   *
   * Generate CSS for all the tab slides
   * NOTE: stored in the 'css' index of database instance option array
   *
   * @return bool true
   */
	public function generate_master_css() {
		$all_instances = $this->plugin_options['instances'];
		$css = "";
		foreach ( $all_instances as $key => $instance ) {
		  $css .= "\r\n" . $instance['css'];
		}
		file_put_contents(TAB_SLIDE_PRO_ROOT . '/ts.css', $css, LOCK_EX);
		return true;
	}
	public function regenerate_instance_css($instance) {
		do_action('tab_slide_regenerate_instance_css', $instance);
		if ( ! is_array($instance) && settype($instance, "integer" ) ) {
			$instance = isset($this->plugin_options['instances'][$instance]) ? $this->plugin_options['instances'][$instance] : false;
		}	
	  	if ($instance !== false) {
			$instance_css = $this->get_css_via_buffer($instance);
			$this->update_instance_option( 'css', $instance_css, $instance['id'] );
		}
	}
	
	public function generate_instance_css($instance) {
		if ( ! is_array($instance) && settype($instance, "integer" ) ) {
			$instance = isset($this->plugin_options['instances'][$instance]) ? $this->plugin_options['instances'][$instance] : false;
		}
		if ( $instance['cssonly'] == 0 || $instance['css'] == "" ) {
			$this->regenerate_instance_css($instance);
		}
		$this->generate_master_css();
		
	}
  /**
   * tab_slide_settings_link ()
   *
   * Create a 'Settings' link on the main plugin settings page
   *
   * @param array of available links
   * @param string filename to check against to add the link to the correct plugin
   * @return bool true
   */
	public function tab_slide_settings_link($links, $file ) {
		static $this_plugin;
		if (!$this_plugin) {
			$this_plugin = plugin_basename(__FILE__);
		}
		// check to make sure we are on the correct plugin
		if ($file == $this_plugin) {
			$settings_link = '<a href="options-general.php?page=tab-slide-pro">Settings</a>'; 
			array_unshift($links, $settings_link); 
		}
		return $links; 
	}
  /**
   * admin_init ()
   *
   * Register tab slide settings and iterate through the version upgrade mechanism if need be
   *
   * @param none
   * @return none
   */
	public function admin_init() {
	    foreach($this->plugin_options as $option => $value) {
	    	//register_setting($this->options_group, $this->get_plugin_option_fullname($option));
	    	register_setting($this->options_group, $this->get_plugin_option_fullname('instances'), array( $this , 'tab_slide_pro_options_validate'));
	    }
	    	    
	    // Upgrade if need be
	    $tab_prev_version = $this->get_plugin_option('version');
	    if ( version_compare( $tab_prev_version, TAB_SLIDE_PRO_VERSION, '<' ) ) tab_slide_pro_upgrade($tab_prev_version);
	}
  /**
   * add_admin_scripts ()
   *
   * Enqueue the necessary tab slide settings page scripts
   *
   * @param none
   * @return none
   */
	public function add_admin_scripts() {
		if ( is_admin() ) {
			if (array_key_exists ( 'page' , $_REQUEST ) && $_REQUEST['page'] == 'tab-slide-pro') {
				wp_enqueue_style( 'tsp-settings', TAB_SLIDE_PRO_URL . '/assets/css/settings.css' );
				wp_enqueue_script('jquery');
				wp_enqueue_style( 'farbtastic' );
				wp_enqueue_style('tsp-multipleselect-css', TAB_SLIDE_PRO_URL . '/assets/js/bsmSelect-master/css/jquery.bsmselect.css');
				wp_enqueue_script( 'farbtastic' );
				wp_enqueue_script('tsp-multipleselect-js', TAB_SLIDE_PRO_URL . '/assets/js/bsmSelect-master/js/jquery.bsmselect.js');
				wp_enqueue_script( 'tsp-settings', TAB_SLIDE_PRO_URL . '/assets/js/settings.js' );
				wp_localize_script('tsp-settings', 'j_options', $this->plugin_options['instances']);
				wp_localize_script( 'tsp-settings', 'PostAjax', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'postNonce' => wp_create_nonce( 'tabslide-post-nonce' ))
				);
			}
		}
	}
  /**
   * admin_menu_init ()
   *
   * Initialize the admin menu hook
   *
   * @return none
   */
	public function admin_menu_init() {
		if( is_admin() ) {			
			//Add the necessary pages for the plugin 
			add_action('admin_menu', array($this, 'add_menu_items'));
		}
	}
  /**
   * add_menu_items ()
   *
   * Deal with the settings page class and related options
   *
   * @return none
   */
	public function add_menu_items ( ) {
		 // Add Top-level Admin Menu
		 include_once( TAB_SLIDE_PRO_ROOT . '/includes/settings.php' );
		 $this->settings = new Tab_Slide_Pro_Settings();
		 add_options_page('Tab Slide Pro', 'Tab Slide Pro', 'manage_options', 'tab-slide-pro',  array($this->settings , 'tab_slide_pro_options_page'));
	}
  /**
   * tab_slide_widgets_init ()
   *
   * Register the tab slide widget area
   *
   * @return none
   */
	public function tab_slide_widgets_init() {
		$all_instances = $this->plugin_options['instances'];
		if ( ! empty($all_instances) ) {
			foreach ( $all_instances as $id => $instance ) {
				if ( 'Widget' == $instance['template_pick'] ) {
						register_sidebar( array(
							'name' => 'Tab Slide - ' . $instance['name'],
							'id' => 'tab-slide-pro' . $instance['id'],
							'description' => 'The tab slide' . $instance['id'] . ' widget area',
							'before_widget' => '<div id="%1$s'. $instance['id'] .'" class="widget-container %2$s">',
							'after_widget' => '</div>',
							'before_title' => '<h3 class="widget-title">',
							'after_title' => '</h3>',
						) );
				}		
			}
		}
	}
	/**
	 * Create a new instance by cloning the parent instance
	 * NOTE: css option field has unique id appended to all ID's and classes
	 *       so the css is generated from scratch again (
	  *      ie the 'css' option is not copied over from the parent instance allowing for unique DOM id's and classes
	 */
	public function create_instance($parent_id) {
		do_action('tab_slide_create_instance', $parent_id);

		if ( is_multisite() && ( $network_wide || is_network_only_plugin($plugin) ) ) {
	                $network_wide = true;
	                $current = get_site_option( 'active_sitewide_plugins', array() );
	        } else {
	                $current = get_option( 'active_plugins', array() );
	        }

		$all_instances = $this->plugin_options['instances'];
		$all_instances[] = $all_instances[$parent_id];
		end($all_instances);
		$new_id = key($all_instances);
		$all_instances[$new_id]['id'] = $new_id;
		$all_instances[$new_id]['name'] = $all_instances[$new_id]['name'] . ' copy';

		$this->update_plugin_option( 'instances', $all_instances );
		$this->regenerate_instance_css ($all_instances[$new_id]);

		return $new_id;
	}
	/**
	 * Delete instance from "instances" option array
	 */
	public function delete_instance($id) {
	  	do_action('tab_slide_delete_instance', $id);

		// Prevent Deletion of default instances
		if ( $id < 2 ) {
			return true;
		}
		$all_instances = $this->plugin_options['instances'];
		unset($all_instances[$id]);
		$this->update_plugin_option( 'instances', $all_instances );
		return true;
	}
	/**
	 * Disable instance by setting "include only" on non-existent post ID
	 */
	public function disable_instance ($id) {
	  	do_action('tab_slide_disable_instance', $id);

		$this->update_instance_option( 'list_pick', 'disabled', $id );
		return true;
	}
	/**
	 * Enable instance by setting "include on all pages"
	 */
	public function enable_instance ($id) {
	  	do_action('tab_slide_enable_instance', $id);

		$this->update_instance_option( 'list_pick', 'all', $id );
		return true;
	}
	/**
	 * Backed AJAX controller
	 * Used for dealing with instances on the tab-slide-pro settings page
	 */
	public function settings_ajax_handler () {
		$nonce = $_REQUEST['postNonce'];
		if ( ! wp_verify_nonce( $nonce, 'tabslide-post-nonce' ) )
			die ( 'Busted!');
		if ( array_key_exists ( 'page' , $_REQUEST ) && $_REQUEST['page'] == 'tab-slide-pro' )
			die ( 'Busted!');
		switch($_REQUEST['fn']){
			case 'clone':
				$output = $this->create_instance($_REQUEST['instance_id']);
				break;
			case 'refresh':
				$instances = $this->get_plugin_option('instances');
				$output = $this->get_css_via_buffer($instances[$_REQUEST['instance_id']]);
				break;
			case 'delete':
				$output = $this->delete_instance($_REQUEST['instance_id']);
				break;
			case 'disable':
				$output = $this->disable_instance($_REQUEST['instance_id']);
				break;
			case 'enable':
				$output = $this->enable_instance($_REQUEST['instance_id']);
				break;
			case 'get_all_options':
				$output = $this->get_plugin_option('instances');
				break;
			case 'update':
				$output = $this->update_instance_option($_REQUEST['instance_id']);
				break;
			case 'savekey':
				$output = $this->update_plugin_option('api_key', $_REQUEST['key']);
				break;
			default:
				$output = 'No function specified, check your jQuery.ajax() call';
				break;
		}
			echo $output;
		die;
	}
  /**
   * do_init_check ()
   *
   * Initialize all the checks to determine whether to load tab slide
   *
   * @param none
   * @return none
   */
	public function do_init_check() {
	  $load_front_end = false;
	  $all_instaces = $this->plugin_options['instances'];

	  $active_instances = array();
	  $active_shortcodes = array();

	  
	  do_action( 'tab_slide_init_check', $all_instaces );

	  if ( ! empty($all_instaces) ){
      foreach( $all_instaces as $key => $instance_options ) {
        $instance_id = $instance_options['id'];	  
        $show_instance = false;

        $check_through_arrays = $this->check_through_arrays($instance_options);
        if ( $check_through_arrays ) {	
          $check_credentials = $this->check_credentials($instance_options);
          if ( $check_credentials ) {
            $check_device = $this->check_device($instance_options);
            if ( $check_device ) {
              if ($instance_options['cookie_settings']['cookie_enabled']) {
                $show_instance = $this->check_cookie( $instance_options['id'], $instance_options['cookie_settings']);
              } else {
                $show_instance = true;
              }
            } 
          }
        }
        if ($show_instance && $instance_options['list_pick'] == 'shortcode' ) {
          if ( $this->find_shortcode() ) {
            $active_shortcodes[$instance_id] = $instance_options;
            $load_front_end = true;
          }
        } else if ($show_instance) {
          $active_instances[$instance_id] = $instance_options;
        }
      }
	  }

	  $this->active_instances = $active_instances;
	  $this->active_shortcodes = $active_shortcodes;

	  if ( ! empty( $active_instances ) || ! empty( $active_shortcodes ) ) {
    	$load_front_end = true;
	    if ( ! empty( $active_instances ) ) {
		    $this->append_html_from_template( $active_instances );
	    }
	  }
	  if ( $load_front_end ) {
		  add_action( 'wp_enqueue_scripts',        array( $this, 'load_front_end_scripts' ));
		  add_action( 'wp_enqueue_scripts',        array( $this, 'load_front_end_styles' ));
	  }
	}
	/* 
	 * Check if shortcode is present on the current page
	 *
	 * @return bool
	 */
	function find_shortcode(){
		global $posts;

		do_action( 'tab_slide_shortcode_check' );

		$found_shortcode = false;

		$pattern = get_shortcode_regex();
		if (   preg_match_all( '/'. $pattern .'/s', $posts[0]->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( 'tabslide', $matches[2] ) )
		{
			if ( strpos( $matches[0][0], 'id=' ) !== false) {
				$found_shortcode = true;
			} else {
				// [tabslide] passed without id
							}
		}

		return apply_filters ( 'tab_slide_found_shortcodes', $found_shortcode);
	}
  /**
   * check_through_arrays ()
   *
   * Check through the exclude/include and disabled pages arrays
   *
   * @param array instance options that hold the arrays to check through
   * @return bool true/false if the instance should be shown/hidden based on include/exclude/disable options
   */
	public function check_through_arrays($instance_options) {
		$show_instance = false;		
		$current_page_id = get_the_ID();
		$disabled_pages_array = $instance_options['disabled_pages'] == "" ? -1 : array_map('trim',explode(",", $instance_options['disabled_pages']));

		switch($instance_options['list_pick']) {
			case 'shortcode':
				$show_instance = true;
			break;
			case 'disabled':
				$show_instance = false;
			break;
			case 'all':
				if ( !in_array( $GLOBALS['pagenow'], $disabled_pages_array ))
					$show_instance = true;
			break;
			case 'include':
				if ( !in_array( $GLOBALS['pagenow'], $disabled_pages_array ))
					$show_instance =  in_array($current_page_id, $instance_options['include_list']);
			break;
			case 'exclude':
				if ( !in_array( $GLOBALS['pagenow'], $disabled_pages_array ))
					$show_instance = !in_array($current_page_id, $instance_options['exclude_list']);
			break;
		}
		return $show_instance;
	}
  /**
   * check_credentials ()
   *
   * Check if tab slide should show based on login credentials
   *
   * @param array instance options that hold the arrays to check through
   * @return bool true
   */
	public function check_credentials($instance_options) {
		do_action( 'tab_slide_check_credentials', $instance_options );
		
		$show_instance = false;
		
		switch ( $instance_options['credentials'] ) {
			case "all":
					$show_instance = true;
				break;
			case "auth":
				if ( is_user_logged_in() )
					$show_instance = true;
				break;
			case "unauth":
				if ( !is_user_logged_in() )
					$show_instance = true;
				break;
		}

		return apply_filters( 'tab_slide_check_credentials', $show_instance, $instance_options, $GLOBALS['pagenow']);

		
	}
  /**
   * check_device()
   *
   * Check if tab slide should show based on device settings
   *
   * @param array instance options that hold the device settings to check through
   * @return bool true if meets the conditions of the device setting 
   */
	public function check_device($instance_options) {
		do_action( 'tab_slide_check_device', $instance_options );

		$show_instance = false;
		if ( isset($instance_options['device']) ) {
			switch ( $instance_options['device'] ) {
				case "all":
						$show_instance = true;
					break;
				case "mobile":
					if ( wp_is_mobile() )
						$show_instance = true;
					break;
				case "desktop":
					if ( !wp_is_mobile() )
						$show_instance = true;
					break;
				default:
						$show_instance = true;
					break;
			}
		} else {
			$show_instance = true;
		}

		return apply_filters( 'tab_slide_check_device', $show_instance, $instance_options);
	}
  public function check_cookie($id, $cookie_settings) {
    global $current_id;
    $current_id = $id;
    $show_instance = $cookie_settings['cookie_render_html'];
    if ( isset( $_COOKIE['tab-slide'][$id] ) ) { //cookie is present
      if($cookie_settings['cookie_count_enabled']) { // cookie count enabled
        list($expiry, $count) = explode('|', $_COOKIE['tab-slide'][$id], 2);
        if ( $cookie_settings['cookie_count'] > $count ) { // cookie count not reached
          $count++;
          setcookie("tab-slide[$id]", "$expiry|$count", $expiry, '/');
          $show_instance = TRUE;
        } else if ($cookie_settings['cookie_render_html']) {
          add_filter('tab_slide_options', array( $this, 'modify_tab_slide_options'));
        }
      } else if ($cookie_settings['cookie_render_html']) {
        add_filter('tab_slide_options', array( $this, 'modify_tab_slide_options'));
      }
    } else { // no cookie present
      $expiry = strtotime( $cookie_settings['cookie_expires'] );
      $count = 1;
      setcookie("tab-slide[$id]", "$expiry|$count", $expiry, '/');
      $show_instance = TRUE;
    }
    return apply_filters( 'tab_slide_check_cookie', $show_instance, $id, $expiry, $count, $cookie_settings );
  }
  public function modify_tab_slide_options ( $options ) {
    global $current_id;
    $options[$current_id]['show_on_load'] = FALSE;
    $options[$current_id]['enable_open_timer'] = FALSE;
    return $options;
  }
  /**
   * append_html_from_template ()
   *
   * Content filter handler: append the html generated from the template
   * Remove the filter handle, after the tab slide html has been included once
   *
   * @param  string html content
   * @return string modified html content
   */
	public function append_html_from_template($active_instances) {
		foreach ( $active_instances as $instance_options ) {
		  switch ( $instance_options['hook'] ) {
			  case "the_content":
				  $this->hook_html['filter']['the_content'] .= $this->load_html_from_template($instance_options);
			  break;
			  case "the_excerpt":
				  $this->hook_html['filter']['the_excerpt'] .= $this->load_html_from_template($instance_options);
			  break;
			  case "wp_footer":
				  $this->hook_html['action']['wp_footer'] .= $this->load_html_from_template($instance_options);
			  break;
			  case "wp_head":
				  $this->hook_html['action']['wp_head'] .= $this->load_html_from_template($instance_options);
			  break;
			  case "custom_filter":
				  $hook = $instance_options['hook_custom'];
				  if ( isset($this->hook_html[$hook]) ) {
					  $this->hook_html['filter'][$hook] .= $this->load_html_from_template($instance_options);
				  } else {
					  $this->hook_html['filter'][$hook] = $this->load_html_from_template($instance_options);
				  }
			  break;
        default:
          $this->hook_html['filter']['the_content'] .= $this->load_html_from_template($instance_options);
        break;
		  }
		}
		foreach ($this->hook_html['action'] as $hook => $html) {
			if ($html != '') {
				add_action( $hook, array( $this, 'append_html_via_action'));
			}
		}
		foreach ($this->hook_html['filter'] as $hook => $html) {
			if ($html != '') {
				add_filter( $hook, array( $this, 'append_html_via_filter'), 1);
			}
		}
	}
	public function append_html_via_filter($content) {
		$current_hook = current_filter();
  	$content .= $this->hook_html['filter'][$current_hook];
		remove_filter( $current_hook, array($this, 'append_html_via_filter'));
		return $content;
	}
	public function append_html_via_action() {
		$current_hook = current_filter();
		remove_action( $current_hook, array($this, 'append_html_via_action'));
		echo $this->hook_html['action'][$current_hook];
	}
  /**
   * load_html_from_template ()
   * 
   * Generate the content html to be included
   *
   * @return string html of the include div
   */
	public function load_html_from_template($instance_options) {
		do_action('tab_slide_html_instance', $instance_options);
		$instance_id = $instance_options['id'];
		$url = $instance_options['window_url'];
		if (substr($url, 0, 7) == 'http://') {
			//$url = substr($url, strlen(get_site_url()));
		} else if ( substr($url, 0, 1) != '/' ) {
			$url = ABSPATH . '/' . $url;
		} else {
			$url = TAB_SLIDE_PRO_ROOT . $url;
		}

		$url = apply_filters('tab_slide_url', $url, $instance_options);

		$instance = $instance_options;
		$html = "<div id='tab_slide_include{$instance_id}' style='display: none'>";
		ob_start();
		include ( $url );
		$html .= ob_get_clean();
		$html .= "</div>";

		return apply_filters('tab_slide_include_container_html', $html, $instance_options);
	}
  /**
   * shortcode_handler ()
   * 
   * Load the necessary styles and scripts and echo the HTML for the tab slide instance
   *
   * @return none
   */
	public function shortcode_handler($atts) {
		$shortcodes = $this->active_shortcodes;

		do_action('tab_slide_shortcode', $shortcodes);

		$args = shortcode_atts( 
		    array(
			'id'   => ''
		    ), 
		    $atts
		);
		$id = $args['id'] == null ? 2 : (int) $args['id'];
		if ( isset($shortcodes[$id]) ) {
			$html = $this->load_html_from_template( $shortcodes[$id] );
			echo $html;
		} else {
			echo null;
		}
	}
  /**
   * load_front_end_styles ()
   *
   * Register and enqueue front end styles
   *
   * @return none
   */
	public function load_front_end_styles() {
		$tsStyleUrl = TAB_SLIDE_PRO_URL . 'ts.css';
		$tsStyleUrl = apply_filters( 'tab_slide_css_url', $tsStyleUrl, 'tab_slide_StyleSheet' );
		wp_register_style('tab_slide_StyleSheet', $tsStyleUrl );
		wp_enqueue_style( 'tab_slide_StyleSheet' );

		do_action('tab_slide_front_end_stylesheet', $this->plugin_options, 'tab_slide_StyleSheet');
	}
  /**
   * load_front_end_scripts ()
   *
   * Register and enqueue front end scripts
   *
   * @return none
   */
	public function load_front_end_scripts() {
		$json_options = array();
		$json_options = $this->active_instances + $this->active_shortcodes;
		$json_options['site_url'] = site_url();
		
		$json_options = apply_filters('tab_slide_options', $json_options);
		
		$json_str = json_encode($json_options);		
		$params = array(
			'j_options' => $json_str
		);
		
		wp_enqueue_script('jquery');

		$tsScriptUrl = TAB_SLIDE_PRO_URL . 'assets/js/tab_slide_pro.js';
		$tsScriptUrl = apply_filters( 'tab_slide_js_url', $tsScriptUrl, $params, 'tab_slide_script' );
		wp_register_script('tab_slide_script', $tsScriptUrl, false);
		wp_enqueue_script('tab_slide_script');
		wp_localize_script('tab_slide_script', 'j_options', $params);

		do_action('tab_slide_front_end_scripts', $params,'tab_slide_script' );

	}
	public function get_version() {
	    if ( ! function_exists( 'get_plugins' ) )
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	    $plugin_data = get_plugin_data( __FILE__ );
	    return $plugin_data['Version'];
	}
	/**
	 * Auto update
	 */
	public function activate_autoupdate() {
	    require ( TAB_SLIDE_PRO_ROOT . '/includes/update.php' ); 
	    $tsp_api_key = self::get_plugin_option('api_key');
	    $tsp_current_version = self::get_version();
	    $tsp_remote_path = 'http://store.zoranc.co/autoupdate/?p='.basename(__FILE__, '.php').'&key='.$tsp_api_key;
	    $tsp_slug = plugin_basename(__FILE__);
	    new Tab_Slide_Pro_Auto_Update ($tsp_current_version, $tsp_remote_path, $tsp_slug, $tsp_api_key);  
	}
	/**
	 * Deactivate wordpress.org update check for tab slide pro
	 */
	public function tsp_deactivate_wp_org_update( $r, $url ) {
	    if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r;
	  
	    $plugins = unserialize( $r['body']['plugins'] );
	    unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
	    unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
	    $r['body']['plugins'] = serialize( $plugins );
	    return $r;
	}
	public function rename_tsp_zip( $source, $remote_source, $thiz ) {
		if(  strpos( $source, 'tab-slide-pro' ) === false )
			return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']). trailingslashit( 'tab-slide-pro' );
		rename($source, $newsource);
		return $newsource;
	}
} // END: class tab_slide_pro

/**
 * Create new instance of the tab_slide object
 */
global $tab_slide_pro;
$tab_slide_pro = new Tab_Slide_Pro();

// Hook to perform action when plugin activated
register_activation_hook( TAB_SLIDE_PRO_FILE_PATH, array($tab_slide_pro, 'activate_tab_slide'));

/**
 * tab_pro_loaded()
 * Allow dependent plugins and core actions to attach themselves in a safe way
 */
function tab_pro_loaded() {
	do_action( 'tab_slide_pro_loaded' );
}
add_action( 'plugins_loaded', 'tab_pro_loaded', 10 );
