<?php
/**
* Site wide footer
*/
?>
    </div>
    <!-- /#main -->
    
    <?php 
    if (is_active_sidebar('slipstream-footer-1') OR is_active_sidebar('slipstream-footer-2') OR is_active_sidebar('slipstream-footer-3')) {
    	?>
    	<!-- Footer -->
		<footer id="footer">
	        <div class="container">
	        	<?php 
	        	get_sidebar('footer'); 
	        	?>
	        </div>
	    </footer>
    	<?php
    }
    ?>
    
    <!-- Credits -->
    <footer id="credits">
    	<div class="container">
    		<p>
    			<?php _e('Built with WordPress &amp; Slipstream Theme by', 'slipstream'); ?>
    			<a href="http://www.themelab.com/" target="_blank" title="WordPress Themes">ThemeLab</a>
    		</p>
    	</div>
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>