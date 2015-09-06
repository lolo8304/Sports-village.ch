<?php
do_action('tab_slide_widget_template'); 
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar("tab-slide-pro{$instance['id']}") ) :
endif;
?>
