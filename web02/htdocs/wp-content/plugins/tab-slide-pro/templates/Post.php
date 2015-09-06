<?php 
do_action('tab_slide_post_template');	
$myID = $instance['post_id'];
$my_post = get_post($myID, ARRAY_A);
//$title = $my_post['post_title'];
$content = $my_post['post_content'];
?>
<div class='content'>
<?php echo do_shortcode($content); ?>
</div>
