<?php
// Handles all current and future upgrades for tab_slide
function tab_slide_pro_upgrade( $from ) {
  if ( !$from || version_compare( $from, '2.0', '<' ) ) tab_slide_pro_upgrade_200();
  if ( !$from || version_compare( $from, '2.0.1', '<' ) ) tab_slide_pro_upgrade_201();
  if ( !$from || version_compare( $from, '2.0.2', '<' ) ) tab_slide_pro_upgrade_202();
  if ( !$from || version_compare( $from, '2.0.3', '<' ) ) tab_slide_pro_upgrade_203();
  if ( !$from || version_compare( $from, '2.0.4', '<' ) ) tab_slide_pro_upgrade_204();
  if ( !$from || version_compare( $from, '2.0.5', '<' ) ) tab_slide_pro_upgrade_205();
  if ( !$from || version_compare( $from, '2.0.6', '<' ) ) tab_slide_pro_upgrade_206();
  if ( !$from || version_compare( $from, '2.0.7', '<' ) ) tab_slide_pro_upgrade_207();
  if ( !$from || version_compare( $from, '2.0.8', '<' ) ) tab_slide_pro_upgrade_208();
  if ( !$from || version_compare( $from, '2.0.9', '<' ) ) tab_slide_pro_upgrade_209();
  if ( !$from || version_compare( $from, '2.1.0', '<' ) ) tab_slide_pro_upgrade_210();
  if ( !$from || version_compare( $from, '2.1.1', '<' ) ) tab_slide_pro_upgrade_211();
  if ( !$from || version_compare( $from, '2.1.2', '<' ) ) tab_slide_pro_upgrade_212();
  if ( !$from || version_compare( $from, '2.1.3', '<' ) ) tab_slide_pro_upgrade_213();
  if ( !$from || version_compare( $from, '2.1.4', '<' ) ) tab_slide_pro_upgrade_214();
}
function tab_slide_pro_upgrade_214() {
	global $tab_slide_pro;
	$all_instances = $tab_slide_pro->get_plugin_option ( 'instances' );
	foreach ( $all_instances as $instance_id => $instance_options ) {
		if ( !isset( $all_instances[$instance_id]['cookie_settings']['cookie_render_html'] ) ) {
			$all_instances[$instance_id]['cookie_settings']['cookie_render_html'] = FALSE;
		}
	}
	
	$tab_slide_pro->update_plugin_option( 'version', '2.1.4' );
	$tab_slide_pro->update_plugin_option( 'instances', $all_instances );
}
function tab_slide_pro_upgrade_213() {
	global $tab_slide_pro;
	$all_instances = $tab_slide_pro->get_plugin_option ( 'instances' );
	$tab_slide_pro->update_plugin_option( 'version', '2.1.3' );

	foreach ( $all_instances as $instance_id => $instance_options ) {
		if ( !isset( $all_instances[$instance_id]["scroll_percentage_start"] ) ) {
			$all_instances[$instance_id]["scroll_percentage_start"] = 90;
		}
		if ( !isset( $all_instances[$instance_id]["scroll_percentage_end"] ) ) {
			$all_instances[$instance_id]["scroll_percentage_end"] = 100;
		}
	}
	$tab_slide_pro->update_plugin_option( 'instances', $all_instances );
}
function tab_slide_pro_upgrade_212() {
	global $tab_slide_pro;
	$all_instances = $tab_slide_pro->get_plugin_option ( 'instances' );
	foreach ( $all_instances as $instance_id => $instance_options ) {
		if ( !isset( $all_instances[$instance_id]["cookie_settings"] ) ) {
			$all_instances[$instance_id]["cookie_settings"] = array(
            "cookie_enabled"       => FALSE,
		        "cookie_count_enabled" => FALSE,
		        "cookie_count"         => 3,
		        "cookie_expires"       => "+1 week"
		        );
		}
		if ( !isset( $all_instances[$instance_id]["animation_closing_speed"] ) ) {
		  $all_instances[$instance_id]["animation_closing_speed"] = $all_instances[$instance_id]["animation_speed"];
		}
	}
  $tab_slide_pro->update_plugin_option( 'instances', $all_instances );
  $tab_slide_pro->update_plugin_option( 'version', '2.1.2' );
}
function tab_slide_pro_upgrade_211() {
	global $tab_slide_pro;
	$all_instances = $tab_slide_pro->get_plugin_option ( 'instances' );
	$tab_slide_pro->update_plugin_option( 'version', '2.1.1' );

	foreach ( $all_instances as $instance_id => $instance_options ) {
		if ( !isset( $all_instances[$instance_id]["hook"] ) ) {
			$all_instances[$instance_id]["hook"] = 'the_content';
		}
		if ( !isset( $all_instances[$instance_id]["hook_custom"] ) ) {
			$all_instances[$instance_id]["hook_custom"] = 'tab_slide_append_content';
		}
	}
	$tab_slide_pro->update_plugin_option( 'instances', $all_instances );
}
function tab_slide_pro_upgrade_210() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.1.0' );
}
function tab_slide_pro_upgrade_209() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.9' );

	$all_instances = $tab_slide_pro->get_plugin_option ( 'instances' );
	foreach ( $all_instances as $instance_id => $instance_options ) {
		// Convert include and exclude strings to arrays
		$all_instances[$instance_id]["include_list"] = is_array ($all_instances[$instance_id]["include_list"]) ? $all_instances[$instance_id]["include_list"] : array_map('trim',explode(",", $instance_options['include_list']));
		$all_instances[$instance_id]["exclude_list"] = is_array ($all_instances[$instance_id]["exclude_list"]) ? $all_instances[$instance_id]["exclude_list"] : array_map('trim',explode(",", $instance_options['exclude_list']));
		// Convert true false tab type to image, text custom and scroll
		if ( $all_instances[$instance_id]["tab_type"] === 1 ) {
			$all_instances[$instance_id]["tab_type"] = 'image';
		} else if (  $all_instances[$instance_id]["tab_type"] === 0 ) {
			$all_instances[$instance_id]["tab_type"] = 'text';
		}
		// Add the custom target element setting
		if ( !isset( $all_instances[$instance_id]["tab_element"] ) ) {
			$all_instances[$instance_id]["tab_element"] = '.make_it_slide' . $instance_id;
		}
	}
	$tab_slide_pro->update_plugin_option( 'instances', $all_instances );
	
}
function tab_slide_pro_upgrade_208() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.8' );
	add_option( 'device', 'all' );
	add_option( 'enable_open_timer', false );
}
function tab_slide_pro_upgrade_207() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.7' );
}
function tab_slide_pro_upgrade_206() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.6' );
	add_option( 'api_key', '' );
}
function tab_slide_pro_upgrade_205() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.5' );
}
function tab_slide_pro_upgrade_204() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.4' );
}
function tab_slide_pro_upgrade_203() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.3' );
}
function tab_slide_pro_upgrade_202() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.2' );
}
function tab_slide_pro_upgrade_201() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0.1' );
}
function tab_slide_pro_upgrade_200() {
	global $tab_slide_pro;
	$tab_slide_pro->update_plugin_option( 'version', '2.0' );
}
