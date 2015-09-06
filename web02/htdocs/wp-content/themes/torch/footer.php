<!--Footer-->
		<footer>
			<div class="container">
				<div class="site-sns">
                <?php 
				for($i=0;$i<10; $i++){
					$social_icon = esc_attr(torch_options_array('social_icon_'.$i));
					$social_link = esc_url(torch_options_array('social_link_'.$i));
					if($social_link !=""){
					echo '<a href="'.$social_link.'" target="_blank"><i class="'.$social_icon.'"></i></a>';
					}
					}
					?>
				</div>
				<div class="site-info">
					<?php printf(__('Powered by <a href="%s" target="_blank">WordPress</a>. Designed by <a href="%s" target="_blank">MageeWP Themes</a>.','torch'),esc_url('http://wordpress.org/'),esc_url('http://www.mageewp.com/'));?>
				</div>
			</div>
		</footer>
	</div>
    <?php wp_footer();?>
</body>
</html>