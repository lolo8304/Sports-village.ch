<?php
/*
 * Import the Tab Slide (FREE) settings and disable Tab Slide(FREE)
 */
global $wpdb;

$ts_free_options_db = $wpdb->get_results( "SELECT * FROM `wp_options` WHERE `option_name` LIKE 'tab_slide%' AND `option_name` NOT LIKE 'tab_slide_pro%';", ARRAY_A );
if( !empty($ts_free_options_db) ){
	if ( count( $this->plugin_options['instances'] ) < 3 ) {
		$id = $this->create_instance( 0 );
		$this->plugin_options['instances'][$id] = $this->plugin_options['instances'][0];
    
    $ts_free_options = array();
    foreach ( $ts_free_options_db as $key => $value ) {
		  $name = substr($ts_free_options_db[$key]['option_name'], 10);
		  $option_value = $ts_free_options_db[$key]['option_value'];
		  $ts_free_options[$name] = $option_value;
	  }     
		if ( substr($ts_free_options['window_url'], 0, 7) !== 'http://' && $ts_free_options['template_pick'] !== 'Custom' ) {
		    $ts_free_options['window_url'] = "/templates/{$ts_free_options['template_pick']}.php";
    } else if ( substr($ts_free_options['window_url'], 0, 7) !== 'http://') {
        $ts_free_options['window_url'] = "/templates/Subscribe.php";
    }
    
    $ts_free_options['tab_image'] = 'assets/images/plus-light.png';
    
    if ( $ts_free_options['template_pick'] == 'Widget' ) {
      foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
				if ( $sidebar['name'] == 'Tab Slide Widget Area' ) {
					$sidebars_widgets = get_option('sidebars_widgets');
					$sidebars_widgets["tab-slide{$id}"] = $sidebars_widgets[(string)$sidebar['id']];
					$sidebars_widgets[$sidebar['id']] = NULL;
					update_option( 'sidebars_widgets',$sidebars_widgets );
				}
			}
    }
	  foreach ($this->plugin_options['instances'][$id] as $key => &$value) {
	    if (array_key_exists($key, $ts_free_options)) {
		  $value = $ts_free_options[$key];
	    }
	  }
	  $this->plugin_options['instances'][$id]['id'] = $id;
	  
	  foreach ( $this->plugin_options['instances'] as $instance_id => $instance_options ) {
		  // Convert include and exclude strings to arrays
		  $this->plugin_options['instances'][$instance_id]["include_list"] = is_array ($this->plugin_options['instances'][$instance_id]["include_list"]) ? $this->plugin_options['instances'][$instance_id]["include_list"] : array_map('trim',explode(",", $instance_options['include_list']));
		  $this->plugin_options['instances'][$instance_id]["exclude_list"] = is_array ($this->plugin_options['instances'][$instance_id]["exclude_list"]) ? $this->plugin_options['instances'][$instance_id]["exclude_list"] : array_map('trim',explode(",", $instance_options['exclude_list']));
		  // Convert true false tab type to image, text custom and scroll
		  if ( $this->plugin_options['instances'][$instance_id]["tab_type"] === 1 ) {
			  $this->plugin_options['instances'][$instance_id]["tab_type"] = 'image';
		  } else if (  $this->plugin_options['instances'][$instance_id]["tab_type"] === 0 ) {
			  $this->plugin_options['instances'][$instance_id]["tab_type"] = 'text';
		  }
		  // Add the custom target element setting
		  if ( !isset( $this->plugin_options['instances'][$instance_id]["tab_element"] ) ) {
			  $this->plugin_options['instances'][$instance_id]["tab_element"] = '.make_it_slide' . $instance_id;
		  }
	  }
		$this->plugin_options['instances'][$id]['name'] = "TabSlide(FREE) Import";

	  $this->update_plugin_option( 'instances', $this->plugin_options['instances'] );
	  
	  // Set the default tab-slide relative path
	  $ts_dependent = 'tab-slide/tab-slide.php';
	  // Attempt to find the actual tab-slide relative path
    if ( ! function_exists( 'get_plugins' ) ) {
	    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $all_plugins = get_plugins();
    foreach ($all_plugins as $plugin_path => $plugin_info) {
      if ($plugin_info['Name'] === 'Tab Slide') {
        $ts_dependent = $plugin_path;
      }
    }
    // Deactivate the free version of tab-slide if active
	  if( is_plugin_active($ts_dependent) ){
	    add_action('update_option_active_plugins', 'deactivate_tab_slide_free');
	    function deactivate_tab_slide_free(){
        global $ts_dependent;
		    deactivate_plugins($ts_dependent);
	    }
	  }
	  // Clean up the database if tab-slide folder is no longer present
	  if(!file_exists (  $ts_dependent ) ){
	     foreach ($ts_free_options_db as $option) {
	      $name = $option['option_name'];
	      delete_option($name);
	     }
	  }
  }
} ?>
