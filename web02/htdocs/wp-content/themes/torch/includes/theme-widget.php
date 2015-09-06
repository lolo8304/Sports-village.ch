<?php
// global $wp_registered_sidebars;
#########################################
function torch_widgets_init() {
		register_sidebar(array(
			'name' => __('Default Sidebar', 'torch'),
			'id'   => 'default_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Displayed Everywhere', 'torch'),
			'id'   => 'displayed_everywhere',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Post Left Sidebar', 'torch'),
			'id'   => 'post_left_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Post Right Sidebar', 'torch'),
			'id'   => 'post_right_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Page Left Sidebar', 'torch'),
			'id'   => 'page_left_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Page Right Sidebar', 'torch'),
			'id'   => 'page_right_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Category Sidebar', 'torch'),
			'id'   => 'category_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Tag Sidebar', 'torch'),
			'id'   => 'tag_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Archive Sidebar', 'torch'),
			'id'   => 'archive_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		register_sidebar(array(
			'name' => __('Search Sidebar', 'torch'),
			'id'   => 'search_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		
		register_sidebar(array(
			'name' => __('Page 404 Right Sidebar', 'torch'),
			'id'   => 'page_404_right_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		
		
	
	global $torch_home_sections;
	
	$torch_home_sections = '{"section-widget-area-name":["Home Page Section One","Home Page Section Two","Home Page Section Three","Home Page Section Four"],"list-item-color":["","#eee","",""],"list-item-image":["","","",""],"list-item-repeat":["","","",""],"list-item-position":["","","",""],"list-item-attachment":["","","",""],"widget-area-padding":["50","50","50","50"],"widget-area-layout":["boxed","boxed","boxed","boxed"],"widget-area-column":["1","1","2","1"],"widget-area-column-item":{"home-page-section-one":["12"],"home-page-section-two":["12"],"home-page-section-three":["6","6"],"home-page-section-four":["12"]}}';

    $home_sections_array = json_decode($torch_home_sections, true);
    if(isset($home_sections_array['section-widget-area-name']) && is_array($home_sections_array['section-widget-area-name']) ){
	$num = count($home_sections_array['section-widget-area-name']);
	for($i=0; $i<$num; $i++ ){
	
	$areaname          = isset($home_sections_array['section-widget-area-name'][$i])?$home_sections_array['section-widget-area-name'][$i]:"";
	$sanitize_areaname = sanitize_title($areaname);
	$color             = isset($home_sections_array['list-item-color'][$i])?$home_sections_array['list-item-color'][$i]:"";
	$image             = isset($home_sections_array['list-item-image'][$i])?$home_sections_array['list-item-image'][$i]:"";
	$repeat            = isset($home_sections_array['list-item-repeat'][$i])?$home_sections_array['list-item-repeat'][$i]:"";
	$position          = isset($home_sections_array['list-item-position'][$i])?$home_sections_array['list-item-position'][$i]:"";
	$attachment        = isset($home_sections_array['list-item-attachment'][$i])?$home_sections_array['list-item-attachment'][$i]:"";
	$layout            = isset($home_sections_array['widget-area-layout'][$i])?$home_sections_array['widget-area-layout'][$i]:"";
	$padding           = isset($home_sections_array['widget-area-padding'][$i])?$home_sections_array['widget-area-padding'][$i]:"";
	$column            = isset($home_sections_array['widget-area-column'][$i])?$home_sections_array['widget-area-column'][$i]:"";
	$columns           = isset($home_sections_array['widget-area-column-item'][$sanitize_areaname ])?$home_sections_array['widget-area-column-item'][$sanitize_areaname ]:array("12");
	

	$j                = 1;
	$column_num       = count($columns);
		 foreach($columns as $widget){
			 if($column_num > 1){
				 $widget_name = $areaname." Column ".$j;
				 }else{
				 $widget_name = $areaname;
				 }
			
			register_sidebar(array(
			'name' => $widget_name,
			'id'   => sanitize_title($widget_name),
			'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>'
			));
			
			$j++;
		  
		   }
		 
	   }
	  }
	

	register_widget('torch_home_service');
	register_widget('torch_home_divider');
	register_widget('torch_home_slogan');
	register_widget('torch_home_portfolio');
	register_widget('torch_home_title');
	register_widget('torch_sidebar_slider');
	register_widget('torch_sidebar_social');
	register_widget('torch_post_tabs');
	register_widget('torch_home_blog');
	register_widget('torch_testimonial_widget');
	register_widget('torch_carousel_widget');
	
	

		
}
add_action( 'widgets_init', 'torch_widgets_init' );



/**
 * Home page service widget
 */

class torch_home_service extends WP_Widget {
 	function torch_home_service() {
 		$widget_ops = array( 'classname' => 'home_widget_service', 'description' => __( 'Display pages as service. Best for homepage section one ', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Service', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {

	for($i=0;$i<4;$i++){
		$defaults['service_'.$i] = '';
		}
	$instance = wp_parse_args( (array) $instance, $defaults ); 
	
	for($i=0;$i<4;$i++){
	?>
   
		 <p><label for="<?php echo $this->get_field_id( 'service_'.$i ); ?>">&nbsp;&nbsp;&nbsp;<?php printf(__( 'Page  %s', 'torch' ),($i+1)); ?>:</label>
				<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'service_'.$i ), 'selected' => absint($instance[ 'service_'.$i] )) ); ?></p>
                      
            
		<?php
	}

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for($i=0;$i<4;$i++){
		$instance['service_'.$i] = absint( $new_instance['service_'.$i] );
	   }
	
		

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );

 		global $post;
 		$page_array = array();
		$icon_array = array();
 		for( $i=0; $i<4; $i++ ) {
 			$var = 'service_'.$i;
 			$page_id = isset( $instance[ $var ] ) ? absint($instance[ $var ]) : '';
	 			
 			if( !empty( $page_id ) &&  $page_id > 0 )
 				array_push( $page_array, $page_id );// Push the page id in the array
 		}
		$get_service_pages = new WP_Query( array(
			'posts_per_page' 			=> -1,
			'post_type'					=>  array( 'page' ),
			'post__in'		 			=> $page_array,
			'orderby' 		 			=> 'post__in'
		) ); 
		echo $before_widget;
		$j        = 0;
		$list_num = count($page_array);
		switch($list_num){
			case 1:
			$column = "12";
			break;
			case 2:
			$column = "6";
			break;
			case 3:
			$column = "4";
			break;
			case 4:
			$column = "3";
			break;
			
			}
			
		if(count($page_array)>0){
			echo '<div class="row">';
	    while( $get_service_pages->have_posts() ):$get_service_pages->the_post();
		$image = "";
		if ( has_post_thumbnail() ) { 
         $image = get_the_post_thumbnail( $post->ID,'service' ); 
		}
		
 		echo '<div class="col-sm-6 col-md-'.$column.'"><div class="service-box text-center">
									'.$image.'
									<h3>'.get_the_title().'</h3>
									<p>'.get_the_excerpt().'</p>
									<a href="'.get_permalink().'">'.__("Read More","torch").'>></a>
								</div></div>';
			$j++;
				endwhile;
		echo '</div>';
				wp_reset_postdata();
		}
		echo $after_widget;
 	
 }
}

   
/**************************************************************************************/

/**
 * Home page divider widget
 */
 class torch_home_divider extends WP_Widget {
 	function torch_home_divider() {
 		$widget_ops = array( 'classname' => 'home_widget_divider', 'description' => __( 'Divider for each row.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Divider', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	
 	$defaults = array('height' => '10'); 		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		
            <p>
               <label for="<?php echo $this->get_field_id( 'height'  ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Height', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'height'  ); ?>" name="<?php echo $this->get_field_name( 'height'  ); ?>" value="<?php echo absint($instance['height']); ?>" class="" placeholder="Divider height"/> px
            </p>
            
            
		<?php

	}

 function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance[ 'height']  = absint( $new_instance['height' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
		$height = absint($height);
		echo $before_widget;
		echo '<div class="divider" style="height:'.$height.'px"></div>';
		echo $after_widget;
 	}
 }
/**************************************************************************************/

/**
 * Home page slogan widget
 */
class torch_home_slogan extends WP_Widget {
 	function torch_home_slogan() {
 		$widget_ops  = array( 'classname' => 'home_widget_slogan', 'description' => '' );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Slogan', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	
    $defaults = array('title'=>'','slogan_content'=>'','btn_text'=>__('Read More', 'torch'),'btn_link'=>'#');
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

           
            <p>
             <label for="<?php echo $this->get_field_id( 'title'  ); ?>"><?php _e('Title', 'torch'); ?>:</label>
            <input id="<?php echo $this->get_field_id( 'title'  ); ?>" type="text" name="<?php echo $this->get_field_name( 'title'  ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="" /> 
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'slogan_content'  ); ?>"><?php _e('Content', 'torch'); ?>:</label>
            <textarea id="<?php echo $this->get_field_id( 'slogan_content'  ); ?>"  name="<?php echo $this->get_field_name( 'slogan_content'  ); ?>" class=""><?php echo esc_textarea($instance['slogan_content']); ?></textarea>
            </p>
            
             <p><label for="<?php echo $this->get_field_id( 'btn_text'  ); ?>"><?php _e('Button Text', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'btn_text'  ); ?>" name="<?php echo $this->get_field_name( 'btn_text'  ); ?>" value="<?php echo esc_attr($instance['btn_text']); ?>" class="" type="text" /> 
            </p>
            <p><label for="<?php echo $this->get_field_id( 'btn_link'  ); ?>"><?php _e('Button Link', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'btn_link'  ); ?>" name="<?php echo $this->get_field_name( 'btn_link'  ); ?>" value="<?php echo esc_url($instance['btn_link']); ?>" class="" type="text" /> 
            </p>
            
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance                     =  $old_instance;
        $instance[ 'title']           =  esc_attr($new_instance['title'] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'slogan_content']  = $new_instance['slogan_content'];
		else
		   $instance[ 'slogan_content']  = stripslashes( wp_filter_post_kses( addslashes($new_instance['slogan_content']) ) );
		
		 $instance[ 'btn_text']      = esc_attr( $new_instance['btn_text']) ;
		 $instance[ 'btn_link']      = esc_url_raw( $new_instance['btn_link']) ;

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
		echo $before_widget;
	   $title          = esc_html( $title ) ;
	   $slogan_content = esc_textarea( $slogan_content ) ;
	   $btn_text       = esc_attr( $btn_text ) ;
	   $btn_link       = esc_url( $btn_link ) ;
		
		echo '<div class="slogan-box">
						<div class="row">
							<div class="col-md-10">
								<div class="slogan-content">
									<h3>'.$title.'</h3>
									<p>'.do_shortcode($slogan_content).'</p>
								</div>
							</div>
							<div class="col-md-2 text-right" style="vertical-align: middle;">
								<a href="'.$btn_link.'" target="_blank"><button class="btn-normal">'.$btn_text.'</button></a>	
							</div>
						</div>						
					</div>';
					
		
		echo $after_widget;
 	}
 }
/**************************************************************************************/

/**
 * Home page portfolio widget
 */
 
class torch_home_portfolio extends WP_Widget {
 	function torch_home_portfolio() {
 		$widget_ops = array( 'classname' => 'home_widget_portfolio', 'description' => __( 'Display pages as portfolio.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Portfolio', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {

	for($i=0;$i<4;$i++){
		$defaults['portfolio_'.$i] = '';
	}
	$instance = wp_parse_args( (array) $instance, $defaults ); 
	
	for($i=0;$i<4;$i++){
	?>
     
            
		 <p><label for="<?php echo $this->get_field_id( 'portfolio_'.$i ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php printf(__( 'Page  %s', 'torch' ),($i+1)); ?>:</label>
				<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'portfolio_'.$i ), 'selected' => absint($instance[ 'portfolio_'.$i] )) ); ?></p>
                      
            
		<?php
	}

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for($i=0;$i<4;$i++){
		$instance['portfolio_'.$i] = absint( $new_instance['portfolio_'.$i] );
	   }
	
		

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );

 		global $post;
 		$page_array = array();
		$icon_array = array();
 		for( $i=0; $i<4; $i++ ) {
 			$var = 'portfolio_'.$i;
 			$page_id = isset( $instance[ $var ] ) ? absint($instance[ $var ]) : '';
			 			
 			if( !empty( $page_id ) &&  $page_id > 0 )
 				array_push( $page_array, $page_id );// Push the page id in the array
 		}
		$get_portfolio_pages = new WP_Query( array(
			'posts_per_page' 			=> -1,
			'post_type'					=>  array( 'page' ),
			'post__in'		 			=> $page_array,
			'orderby' 		 			=> 'post__in'
		) ); 
		echo $before_widget;
		$j        = 0;
		$list_num = count($page_array);
		switch($list_num){
			case 1:
			$column = "12";
			break;
			case 2:
			$column = "6";
			break;
			case 3:
			$column = "4";
			break;
			case 4:
			$column = "3";
			break;
			
			}
			
		echo '<div class="portfolio"><div class="row">';
		if(count($page_array)>0){
			
	    while( $get_portfolio_pages->have_posts() ):$get_portfolio_pages->the_post();
				
 		$tags = get_the_tags(get_the_ID());
	   $tags_list = '<ul>';
	   if(is_array($tags)){
	   foreach ( $tags as $tag ) {
		  $tag_link   = get_tag_link( $tag->term_id );
		  $tags_list .= "<li><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
		  $tags_list .= "{$tag->name}</a></li>";
	   }
	   }
	  $tags_list .= '</ul>';

     
       echo '<div class="col-sm-6 col-md-'.$column.'"><div class="portfolio-box text-center">';
	   
      if ( has_post_thumbnail() ) { 
	   echo '<a href="'.get_permalink().'">';
		the_post_thumbnail(array(300,999999));
	   echo '</a>'; 
	  } 				
	  echo '<div class="portfolio-box-title"><a href="'.get_permalink().'"><h3>'.get_the_title().'</h3></a>
	  									'.$tags_list.'
									</div>
								</div>
							</div>';
							
	
				endwhile;
	 echo '</div></div>';
				wp_reset_postdata();
		}
		echo $after_widget;
 	
 }
}


/**************************************************************************************/


/**
 * Home page title widget
 */
 class torch_home_title extends WP_Widget {
 	function torch_home_title() {
 		$widget_ops = array( 'classname' => 'home_widget_title', 'description' => __( 'Display section title.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Section Title', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	
 	$defaults = array('title' => '','sub_title'=>''); 		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		
             <p>
               <label for="<?php echo $this->get_field_id( 'title'  ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Title', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title'  ); ?>" name="<?php echo $this->get_field_name( 'title'  ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="" /> 
            </p>
            
             <p>
               <label for="<?php echo $this->get_field_id( 'sub_title'  ); ?>"><?php _e('Sub-Title', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'sub_title'  ); ?>" name="<?php echo $this->get_field_name( 'sub_title'  ); ?>" value="<?php echo esc_attr( $instance['sub_title'] ); ?>" class="" /> 
            </p>
            
            
		<?php

	}

 function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance[ 'title']       =  esc_attr($new_instance['title' ]) ;
		$instance[ 'sub_title']   =  esc_attr($new_instance['sub_title' ]) ;

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
		$title      = esc_html( $title ) ;
	    $sub_title  = esc_html( $sub_title ) ;
	   
		echo $before_widget;
		echo '<div class="title-wrapper">
							<h2 class="module-title">'.$title.'</h2>
							<p class="module-description">'.$sub_title.'</p>
						</div>';
		echo $after_widget;
 	}
 }
/**************************************************************************************/
/**
 * Sidebar slider.
 */
class torch_sidebar_slider extends WP_Widget {
 	function torch_sidebar_slider() {
 		$widget_ops = array( 'classname' => 'page_widget_slider', 'description' => __( 'Display some pages as slider.', 'torch' ) );
		$control_ops = array( 'width' => 250, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Widget Slider', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
 		for ( $i=0; $i<6; $i++ ) {
 			$var = 'page_id'.$i;
 			$defaults[$var] = '';
 		}
 		$instance = wp_parse_args( (array) $instance, $defaults );
 		for ( $i=0; $i<6; $i++ ) {
 			$var = 'page_id'.$i;
 			$var = absint( $instance[ $var ] );
		}
	?>
		<?php for( $i=0; $i<6; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php _e( 'Page', 'torch' ); ?>:</label>
				<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => absint($instance[key($defaults)]) ) ); ?>
			</p>
		<?php
		next( $defaults );
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<6; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );

 		global $post;
 		$page_array = array();
 		for( $i=0; $i<6; $i++ ) {
 			$var = 'page_id'.$i;
 			$page_id = isset( $instance[ $var ] ) ? absint($instance[ $var ]) : '';
 			
 			if( !empty( $page_id ) && $page_id > 0 )
 				array_push( $page_array, $page_id );
 		}
		$get_featured_pages = new WP_Query( array(
			'posts_per_page' 			=> -1,
			'post_type'					=>  array( 'page' ),
			'post__in'		 			=> $page_array,
			'orderby' 		 			=> 'post__in'
		) ); 
		echo $before_widget; ?>
			<?php 
			$i = 0;
			$controller = '';
			$images     = '';
 			while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
				$page_title = get_the_title();
				$active     = '';
				if($i==0) $active = 'active';
				
				if (has_post_thumbnail( get_the_ID() ) ):
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'side-slider' );
				
				$controller .= '<li data-target="#carousel-slider-generic" data-slide-to="'.$i.'" class="'.$active.'"></li>'; 
				$images     .= '<div class="item '.$active.'"><a href="'.get_permalink().'"><img src="'.esc_url($image[0]).'" alt="'.get_the_title().'"></a></div>';
				endif;
				$i++;
				endwhile;
				?>
				<div class="widget-slider">
										<div id="carousel-slider-generic" class="carousel slide" data-ride="carousel">
											<!-- Indicators -->
											<ol class="carousel-indicators">
												<?php echo $controller;?>
											</ol>
											<!-- Wrapper for slides -->
											<div class="carousel-inner">
												<?php echo $images;?>
											</div>
										</div>
										<div class="carousel-bg"></div>
									</div>
			<?php
	 		wp_reset_postdata();
 			?>
		<?php 
		echo $after_widget;
 	}
 }
/**************************************************************************************/


/**
 * Sidebar social network widget
 */
 class torch_sidebar_social extends WP_Widget {
 	function torch_sidebar_social() {
 		$widget_ops = array( 'classname' => 'torch_sidebar_social', 'description' => __( 'Display sidebar social network.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Social Network', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	$social_icons = array('fa fa-facebook'=>'facebook',
						  'fa fa-flickr'=>'flickr',
						  'fa fa-google-plus'=>'google plus',
						  'fa fa-linkedin'=>'linkedin',
						  'fa fa-pinterest'=>'pinterest',
						  'fa fa-twitter'=>'twitter',
						  'fa fa-tumblr'=>'tumblr',
						  'fa fa-digg'=>'digg',
						  'fa fa-rss'=>'rss',
						 
						  );
		
	for($i=0;$i<9;$i++){
		$defaults['social_icon_'.$i] = '';
		$defaults['social_link_'.$i] = '';
	}
	$instance = wp_parse_args( (array) $instance, $defaults ); 
	
	for($i=0;$i<9;$i++){
	?>
         
		<p>
         <label for="<?php echo $this->get_field_id( 'social_icon_'.$i  ); ?>"><?php _e('Social Icon', 'torch'); ?>:</label>
             <select id="<?php echo $this->get_field_id( 'social_icon_'.$i ); ?>" name="<?php echo $this->get_field_name( 'social_icon_'.$i  ); ?>">
           <?php 
		
		   foreach($social_icons as $key=>$val){
			   $selected = '';
			  if( $instance[ 'social_icon_'.$i ] == $key) $selected = 'selected="selected"';
			   ?>
           <option   value="<?php echo esc_attr( $key );?>" <?php echo $selected ;?>><?php echo esc_attr( $val );?></option>
           <?php }?>
            </select>
            </p>
             <p>
               <label for="<?php echo $this->get_field_id( 'social_link_'.$i  ); ?>"><?php _e('Social Link', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'social_link_'.$i   ); ?>" name="<?php echo $this->get_field_name(  'social_link_'.$i   ); ?>" value="<?php echo esc_url( $instance[ 'social_link_'.$i ] ); ?>" class="" /> 
            </p>
            
            
		<?php
	}
	}
	
 function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
     
		for($i=0;$i<9;$i++){
		 $instance[ 'social_icon_'.$i] =  esc_attr($new_instance['social_icon_'.$i]) ;
		 $instance[ 'social_link_'.$i] =  esc_url_raw($new_instance['social_link_'.$i ]) ;
	}

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
		
		echo $before_widget;
		echo '<div class="widget-sns">';
		for($i=0;$i<9; $i++){
					$social_icon = esc_attr($instance['social_icon_'.$i]);
					$social_link = esc_url($instance['social_link_'.$i]);
					if($social_link !=""){
					echo '<a href="'.esc_url($social_link).'" target="_blank"><i class="'.esc_attr($social_icon).'"></i></a>';
					}
					}
	
        echo '</div>';
		echo $after_widget;
 	}
 }
/**************************************************************************************/

/**
 * Popular posts and latest posts tabs
 */
 class torch_post_tabs extends WP_Widget {
 	function torch_post_tabs () {
 		$widget_ops = array( 'classname' => 'home_widget_title', 'description' => __( 'Display popular posts and latest posts tabs.', 'torch' ) );
		$control_ops = array( 'width' => 250, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Posts Tabs', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	
 	$defaults = array('popular_num' => '5','recent_num'=>'5'); 		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		
             <p>
               <label for="<?php echo $this->get_field_id( 'popular_num'  ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Popular Posts List Num', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'popular_num'  ); ?>" name="<?php echo $this->get_field_name( 'popular_num'  ); ?>" value="<?php echo absint( $instance['popular_num'] ); ?>" class="" /> 
            </p>
            
             <p>
               <label for="<?php echo $this->get_field_id( 'recent_num'  ); ?>"><?php _e('Resent Post List Num', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'recent_num'  ); ?>" name="<?php echo $this->get_field_name( 'recent_num'  ); ?>" value="<?php echo absint( $instance['recent_num'] ); ?>" class="" /> 
            </p>
            
            
		<?php

	}

 function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance[ 'popular_num']  =  absint($new_instance['popular_num']) ;
		$instance[ 'recent_num']   =  absint($new_instance['recent_num']) ;

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
		
		echo $before_widget;
		echo '<div class="widget-posts-tabs">
									<div class="widget-post">
										<ul class="nav nav-tabs">
  											<li class="active"><a href="#pop" data-toggle="tab">'.__( 'Popular Posts', 'torch').'</a></li>
  											<li class=""><a href="#rec" data-toggle="tab">'.__( 'Recent Posts', 'torch').'</a></li>
  										</ul>
  										<!-- Tab panes -->
  										<div class="tab-content">
  											<div class="tab-pane active" id="pop">
  												<ul>';
										$this->torch_tabs_popular_posts($instance);
  													
  			echo '</ul>
  											</div>
  											<div class="tab-pane" id="rec">
  												<ul>';
										$this->torch_tabs_latest_posts($instance);
  													
            echo '</ul>
  											</div>
  										</div>
									</div>
								</div>';
		echo $after_widget;
 	}
	
	
	
/*Method to load popular posts*/
function torch_tabs_popular_posts($instance) 
{
	extract( $instance );
	$popular = new WP_Query('orderby=comment_count&posts_per_page='.$popular_num);

	while ($popular->have_posts()) : $popular->the_post();
	?>
    <li>
      <?php 
         if ( has_post_thumbnail() ) {
              the_post_thumbnail("side-slider");
               } 
      ?>
       <div class="tab-inner-box">
         <div><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
          <div><i class="fa fa-comments"></i>&nbsp;&nbsp;<?php the_date("M d.Y")?></div>
          </div>
		   <div class="clear"></div>
    </li>
	<?php
	endwhile; 
	wp_reset_postdata() ;
}

/*Method to load latest posts*/
function torch_tabs_latest_posts( $instance ) 
{
	extract( $instance );
	$the_query = new WP_Query('showposts='. $recent_num .'&orderby=post_date&order=desc');
	
	while ($the_query->have_posts()) : $the_query->the_post(); 
	?>
	<li>
      <?php 
         if ( has_post_thumbnail() ) {
              the_post_thumbnail("side-slider");
               } 
      ?>
       <div class="tab-inner-box">
         <div><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
          <div><i class="fa fa-comments"></i>&nbsp;&nbsp;<?php the_date("M d.Y")?></div>
          </div>
		  <div class="clear"></div>
    </li>
	<?php
	endwhile; 
	wp_reset_postdata() ;
}

 }
 
/**************************************************************************************/


/**
 * Home page blog widget
 */
 
class torch_home_blog extends WP_Widget {
 	function torch_home_blog() {
 		$widget_ops = array( 'classname' => 'home_widget_blog', 'description' => __( 'Display pages as blog.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Blog', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {

	$instance = wp_parse_args( (array) $instance, array("blog_num"=>"4") ); 
	?>
             <p>
               <label for="<?php echo $this->get_field_id( 'blog_num'  ); ?>"><?php _e('Posts List Num', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'blog_num'  ); ?>" name="<?php echo $this->get_field_name( 'blog_num'  ); ?>" value="<?php echo absint( $instance['blog_num'] ); ?>" class="" /> 
            </p>
            
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['blog_num'] = absint( $new_instance['blog_num'] );
		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
 		global $post;
 		$blog_num = (is_numeric($blog_num) && $blog_num>0)?$blog_num:4;
		$get_posts = new WP_Query( array(
			'posts_per_page' 			=> $blog_num,
			'paged'                     => 1,
			'post_type'					=>  array( 'post' )
		) ); 
		echo $before_widget;
		$j         = 0 ;
		$css_style = "";
		$return    = "";
		$items     = "";
		
	
	    while( $get_posts->have_posts() ):$get_posts->the_post();
		  
			  
		  $num_comments = get_comments_number(); 

			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __('No Comments',"torch");
				} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __(' Comments',"torch");
				} else {
					$comments = __('1 Comment',"torch");
				}
				$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
			} else {
				$write_comments =  '';
			}

 	      $items .= '<div class="col-md-6"><div class="bloglist-box">';
		 
		  if ( has_post_thumbnail() ) { 
		  $featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog' );
	      $items .= '<a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.esc_url( $featured_image_url[0]).'" alt="'.get_the_title().'"/></a>';

	  } else{
		  $css_style = "style='margin-left:0;'";
		  
		  }
		
		  $items .= '<div class="bloglist-content" '.$css_style.'>
						<div class="entry-header">
							<div class="entry-meta">
								<div class="entry-date"><a href="'.get_day_link('', '', '').'">'.get_the_date("M d, Y").'</a></div>';
		  $items .= $write_comments;
											
		  $items .= '</div><a href="'.get_permalink().'"><h1 class="entry-title">'.get_the_title().'</h1></a>
										<div class="entry-title-dec"></div>
									</div>
									<div class="entry-summary">'.get_the_excerpt().'</div>
									<div class="entry-footer">
										<a href="'.get_permalink().'"><div class="entry-more">'.__("Read More","torch").'&gt;&gt;</div></a>
									</div>
								</div>';
								
		  $items .= '</div></div> ';
		  
		  $j++;
		  if($j%2 == 0){
			  $return .= '<div class="row">'.$items.'</div>';
			  $items  = "";
			  }
				endwhile;
	 if($items  != "")
	 $return .= '<div class="row">'.$items.'</div>';
	// $return = '<div class="container">'.$return.'</div>';
	  echo $return ;
	  wp_reset_postdata();
	  echo $after_widget;
 	
 }
}

/**************************************************************************************/

/**
 * testimonial widget
 */

class torch_testimonial_widget extends WP_Widget {
 	function torch_testimonial_widget() {
 		$widget_ops = array( 'classname' => 'torch_testimonial_widget', 'description' => __( 'Torch testimonial.', 'torch' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Testimonial', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
    $defaults = array('avatar'=>'','byline'=>'','rating'=>50,'content'=>'');
	$instance = wp_parse_args( (array) $instance, $defaults ); 

	?>
    
     <p>
            <label for="<?php echo $this->get_field_id( 'avatar'  ); ?>"><?php _e('Avatar', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'avatar' ); ?>" placeholder="Avatar URL" name="<?php echo $this->get_field_name( 'avatar' ); ?>" value="<?php echo esc_url( $instance['avatar'] ); ?>" class="" /> 
            </p>
            
     <p>
            <label for="<?php echo $this->get_field_id( 'byline'); ?>"><?php _e('Byline', 'torch'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'byline'); ?>" name="<?php echo $this->get_field_name( 'byline' ); ?>" value="<?php echo esc_attr( $instance['byline'] ); ?>" class="" /> 
            </p>
   
          <p>
         <label for="<?php echo $this->get_field_id( 'rating'); ?>"><?php _e('Rating', 'torch'); ?>:</label>
         <select id="<?php echo $this->get_field_id( 'rating'); ?>" name="<?php echo $this->get_field_name( 'rating'); ?>">
          <option <?php echo selected("50",esc_attr( $instance['rating'] ));?> value="50">5</option>
          <option <?php echo selected("45",esc_attr( $instance['rating'] ));?> value="45">4.5</option>
          <option <?php echo selected("40",esc_attr( $instance['rating'] ));?> value="40">4</option>
          <option <?php echo selected("35",esc_attr( $instance['rating'] ));?> value="35">3.5 </option>
          <option <?php echo selected("30",esc_attr( $instance['rating'] ));?> value="30">3</option>
          <option <?php echo selected("25",esc_attr( $instance['rating'] ));?> value="25">2.5</option>
          <option <?php echo selected("20",esc_attr( $instance['rating'] ));?> value="20">2</option>
          <option <?php echo selected("15",esc_attr( $instance['rating'] ));?> value="15">1.5</option>
          <option <?php echo selected("10",esc_attr( $instance['rating'] ));?> value="10">1 </option>
         </select>
 </p>
 
		  <p>
            <label for="<?php echo $this->get_field_id( 'content'); ?>"><?php _e('Content', 'torch'); ?>:</label>
            <textarea id="<?php echo $this->get_field_id( 'content'); ?>"  name="<?php echo $this->get_field_name( 'content'); ?>" class=""><?php echo esc_textarea( $instance['content'] ); ?></textarea>
            </p>
                      
            
		<?php
	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;+
		$instance['avatar']  = esc_url_raw( $new_instance['avatar'] );
		$instance['byline']  = esc_attr( $new_instance['byline'] );
		$instance['rating']  = absint( $new_instance['rating'] );
		$instance['content'] = esc_textarea( $new_instance['content'] );
	
		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );

		echo $before_widget;
		$star     = '';
		
            $rating_i = intval($rating/10); 
			$rating_c = 5 - $rating/10;
			
			for($j=0; $j<$rating_i; $j++)
			{
				$star    .= '<i class="fa fa-star"></i>';
				
				}
			if($rating%10 != 0){
				$star    .= '<i class="fa fa-star-half-o"></i>';
				}
			if($rating_c >= 1){
				for($k=0;$k<intval($rating_c);$k++){
				$star    .= '<i class="fa fa-star-o"></i>';	
					}
				}
		if($avatar != ""){
			$avatar = '<img src="'.esc_url( $avatar ).'" alt="'.esc_attr( $byline ).'"/>';
			}
	    echo '<div class="testimonial-box">
		
								<div class="testimonial-author-wrapper">
									'.$avatar.'
									<div class="testimonial-author text-center">
										<p>'.esc_attr( $byline ).'</p>
										<p>'.$star.'</p>
									</div>
								</div>
								<div class="testimonial-content"><i class="fa fa-quote-left"></i>'.do_shortcode(esc_textarea($content)).'</div>								
							</div>';
							
		echo $after_widget;
 	
 }
}

//**************************************************************************************/
 
 /**
 * Carousel
 */
 
 class torch_carousel_widget extends WP_Widget {
 	function torch_carousel_widget() {
 		$widget_ops = array( 'classname' => 'torch_carousel_widget', 'description' => '' );
		$control_ops = array( 'width' => 300, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'Torch: Carousel', 'torch' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
 		for ( $i=0; $i<10; $i++ ) {
 			$defaults['image_'.$i]  = '';
 		}
		$defaults['list_num']  = '6';
 		$instance = wp_parse_args( (array) $instance, $defaults );
 	
	?>
    
          <p>
         <label for="<?php echo $this->get_field_id( 'list_num' ); ?>">&nbsp;&nbsp;<?php _e('Display Num', 'torch'); ?>:</label>
         <select id="<?php echo $this->get_field_id( 'list_num'  ); ?>" name="<?php echo $this->get_field_name( 'list_num'  ); ?>">
         <option  <?php echo selected("1",absint($instance['list_num']));?> value="1"> 1 </option>
          <option <?php echo selected("2",absint($instance['list_num']));?> value="2"> 2 </option>
          <option <?php echo selected("3",absint($instance['list_num']));?> value="3"> 3 </option>
          <option <?php echo selected("4",absint($instance['list_num']));?> value="4"> 4 </option>
          <option <?php echo selected("5",absint($instance['list_num']));?> value="5"> 5 </option>
          <option <?php echo selected("6",absint($instance['list_num']));?> value="6"> 6 </option>
          <option <?php echo selected("7",absint($instance['list_num']));?> value="7"> 7 </option>
          <option <?php echo selected("8",absint($instance['list_num']));?> value="8"> 8 </option>
          <option <?php echo selected("9",absint($instance['list_num']));?> value="9"> 9 </option>
          <option <?php echo selected("10",absint($instance['list_num']));?> value="10"> 10 </option>
         </select>
 </p>
 
		<?php for( $i=0; $i<10; $i++) { 
		$title = isset($instance['title_'.$i])?$instance['title_'.$i]:"";
		$image = isset($instance['image_'.$i])?$instance['image_'.$i]:"";
		
		?>
         <p>
            <label for="<?php echo $this->get_field_id( 'title_'.$i  ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Title', 'torch'); echo " ".($i+1) ;?>:</label>
			<input id="<?php echo $this->get_field_id( 'title_'.$i ); ?>" name="<?php echo $this->get_field_name( 'title_'.$i ); ?>" value="<?php echo esc_attr($title) ; ?>" class="" /> 
            </p>
            
			 <p>
            <label for="<?php echo $this->get_field_id( 'image_'.$i  ); ?>"><?php _e('Image URL', 'torch'); echo " ".($i+1);?>:</label>
			<input id="<?php echo $this->get_field_id( 'image_'.$i ); ?>" name="<?php echo $this->get_field_name( 'image_'.$i ); ?>" value="<?php echo esc_url($image) ; ?>" class="" /> 
            </p>          
		<?php

		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<10; $i++ ) {
			$instance['image_'.$i]  = esc_url_raw($new_instance['image_'.$i])  ;
			$instance['title_'.$i]  = esc_attr($new_instance['title_'.$i])  ;
	
		}
        $instance['list_num']  = absint($new_instance['list_num'])  ;
		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 	    
		echo $before_widget;
		?>
<div id="torch-carousel" class="owl-carousel clients" data-num="<?php echo absint($instance['list_num']);?>">
<?php
for( $i=0; $i<10; $i++ ) {
			if($instance['image_'.$i]  != ''){
				echo ' <div class="item"><img src="'.esc_url($instance['image_'.$i]).'" data-toggle="tooltip" data-placement="top" title="'.esc_html($instance['title_'.$i]).'" data-original-title="'.esc_html($instance['title_'.$i]).'" alt="'.esc_html($instance['title_'.$i]).'" /></div>';
				}
	
		}
?>
</div>
		<?php 
		echo $after_widget;
 	}
 }