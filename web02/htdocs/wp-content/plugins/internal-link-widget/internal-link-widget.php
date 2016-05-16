<?php
/*
Plugin Name: Internal Link Widget
Plugin URI: http://wordpress.org/plugins/internal-link-widget
Description: Add a simple widget to handle interal link without hardcoding it as you would do with the normal text widget.
Version: 0.3
Author: Martino Stenta
Author URI: http://www.noiza.com
License: GPLv2 or later
Text Domain: int_link_wdg
Domain Path: /languages/
*/

// Localization


class InternalLinkWidget extends WP_Widget {

	function __construct(){
		$plugin_dir = basename(dirname(__FILE__)) . '/languages/'; 
    	load_plugin_textdomain( 'int_link_wdg', false, $plugin_dir );
		parent::__construct(
			'internal_link', 
			__('Internal Link', 'int_link_wdg'), 
			array( 'description' => __( 'Internal link with title and text', 'int_link_wdg' ), ) 
		);
	}

  function widget( $args, $instance ){
    extract($args);
    $text = $instance['text'];
    if ( ! isset($instance['wpage']) || (int) $instance['wpage'] <= 0 ) return;
    $page = get_post( $instance['wpage'] );
    echo $args['before_widget'];
    if ( isset($instance['title']) || $instance['checkbox'] AND $instance['checkbox'] == '1' ) {
       $title = apply_filters( 'widget_title', $instance['title'] );
       if ( $title ) echo $args['before_title'] . $title . $args['after_title'];
    }
    echo '<div class="internal-link-block link-to-'. $page->ID .'">';
    echo '<a href="' . get_permalink( $page ) .'">' . $text . '</a>';
    echo '</div>';
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ){
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['text'] = $new_instance['text'];
    $instance['checkbox'] = $new_instance['checkbox'];
    if ( isset( $new_instance['wpage'] ) && (int) $new_instance['wpage'] > 0 ) {
      $instance['wpage'] = $new_instance['wpage'];
    }
    return $instance;
  }

  function form( $instance ){   
    $title = esc_attr($instance['title']);
    $text = esc_attr($instance['text']);
    $checkbox = esc_attr($instance['checkbox']);
 	?>
    <p><label for="<?php echo $this->get_field_id('title');?>"><?php _e('Link title:', 'int_link_wdg'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title; ?>" />
    </p>
	<p><input id="<?php echo $this->get_field_id('checkbox'); ?>" name="<?php echo $this->get_field_name('checkbox'); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
	<label for="<?php echo $this->get_field_id('checkbox'); ?>"><?php _e('Show title', 'int_link_wdg'); ?></label>
	</p>

    <p>
    <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Link text:', 'int_link_wdg'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
    </p>
    <p class="dropdown-link-box">
    <label for="<?php echo $this->get_field_id('wpage'); ?>"><?php _e('Link to:', 'int_link_wdg'); ?> </label><br>
    <?php
    
    $instance = wp_parse_args( (array) $instance, array( 'wpage'=>'-1' ) );
    $args = array(
      'id' => $this->get_field_id('wpage'),
      'name' => $this->get_field_name('wpage'),
      'show_option_none' =>  __('None', 'int_link_wdg'),
      'option_none_value' => '-1',
      'selected' => $instance['wpage']
    );
    wp_dropdown_pages( $args );
    echo '</p>';
 	}

}



function ilw_load_widget() {
    register_widget( 'InternalLinkWidget' );
}
add_action( 'widgets_init', 'ilw_load_widget' );


function ilw_dropdown_style() {
   echo '<style type="text/css">
           .dropdown-link-box select {max-width:355px; font-size:12px;}
         </style>';
}

add_action('admin_head', 'ilw_dropdown_style');