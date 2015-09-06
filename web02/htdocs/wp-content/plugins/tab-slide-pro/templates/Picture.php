<?php 
do_action('tab_slide_picture_template');
$url   = $instance['picture_url'];
$width = $instance['open_width'] . $instance['window_unit'];
?>
<img class='tab_slide_image' src="<?php echo $url; ?>" style="width:auto;height:auto;"></img>
