<?php 
do_action('tab_slide_video_template'); 
$url   = $instance['video_url'];
$width = $instance['open_width'] . $instance['window_unit'];
?>
<object width="<?php echo $width; ?>">
    <param name='movie' value="<?php echo $url; ?>">
    </param> 
    <param name='allowFullScreen' value='true'>
    </param>
    <embed src="<?php echo $url; ?>" type='application/x-shockwave-flash' allowfullscreen='true' width="<?php echo $width; ?>">
    </embed>
</object>

