<div class="homepage-main" role="main">
<?php echo torch_get_default_slider();?>
<?php 
	global $torch_home_sections;
    if($torch_home_sections !=""){
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
	$columns           = isset($home_sections_array['widget-area-column-item'][$sanitize_areaname ])?$home_sections_array['widget-area-column-item'][$sanitize_areaname ]:"";
	$background_style = ""; 
	
	
    if ($image!="") {
	$background_style .= "background-image:url('".$image. "');background-repeat:".$repeat.";background-position:".$position.";background-attachment:".$attachment.";";
	}
	
	if( $color !=""){
	$background_style .= "background-color:".$color.";";
	 }
	if(is_numeric($padding))
	{
		$background_style .= "padding-top:".$padding."px;padding-bottom:".$padding."px;";
		}
	if($layout == "full"){
		$container = 'full-width';
		}else{
	    $container = 'container';
			}
	
	$column_num       = count($columns);
	$j               = 1;
   
		   echo '<section class="home-section '.$sanitize_areaname.'" style="'.$background_style.'"><div class="'.$container.'">';
	
		if(is_array($columns)){	
		    
	        echo '<div class="row">';			  
		   foreach($columns as $columnItem){
			  
			   if($column_num > 1){
				 $widget_name = $areaname." Column ".$j;
				 
				 }else{
				 $widget_name = $areaname;
				 }
			
			echo '<div class="col-md-'.$columnItem.'">';
		   dynamic_sidebar(sanitize_title($widget_name));
		   echo '</div>';
		   $j++;
		   }
		  
	          echo '</div>';
			
		    
	   }else{
	
		   echo '<div class="col-md-full">';
		   dynamic_sidebar($sanitize_areaname);
		   echo '</div>';
		
		   }
		   echo '<div class="clear"></div></div></section>';
	      
	         }
		   }
	   }
?>
		</div>