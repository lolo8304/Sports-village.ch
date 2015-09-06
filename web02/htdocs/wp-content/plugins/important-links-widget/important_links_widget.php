<?php
/*
Plugin Name: Important Links Widget
Plugin URI: http://wordpress.org/extend/plugins/important-links-widget/
Description: Adds a simple widget that contains important links for use on a community blogging site - new post, new page, login, logout, etc...
Author: D'Arcy Norman
Version: 0.1
Author URI: http://www.darcynorman.net/
*/
 
function importantlinks_widget() {

	$out = "<li class=\"widget widget-important-links\"><h3>Important Links</h3>";
	$out .= "<ul>";
	$siteurl = get_option('siteurl');
	
	if ( is_user_logged_in() ) {
		
		$out .= "<li><a href=\"".$siteurl ."/wp-admin/\">Dashboard</a></li>";
		$out .= "<li><a href=\"".$siteurl ."/wp-admin/post-new.php\">New blog post</a></li>";
		$out .= "<li><a href=\"".$siteurl ."/wp-admin/page-new.php\">New page</a></li>";

		$out .= "<li><a href=\"". wp_logout_url( $siteurl ) ."\">Logout</a></li>";

		
		$out .= "</ul>";
		
	} else {
		// not logged in. give 'em a link to do that.
		$out .= "<li><a href=\"". wp_login_url( get_bloginfo('url') ) . "\" title=\"Login\">Login</a></li>";
	  
	}
	
	$out .= "</ul></li>";
	echo $out;
}
 
function init_importantlinks(){
	register_sidebar_widget("Important Links", "importantlinks_widget");     
}
 
add_action("plugins_loaded", "init_importantlinks");
 
?>