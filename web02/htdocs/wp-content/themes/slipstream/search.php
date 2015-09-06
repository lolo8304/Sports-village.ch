<?php
/**
* Search Results
*/

get_header();
?>

<div class="container">
	<!-- Content -->
	<section>
		<?php
		// Search Results
	    if (have_posts()) {
	        while (have_posts()) {
	            the_post();
	            get_template_part('loop','post');
	        }
	        
	        // Pagination
	        // Get links and check they are strings - if null, it means there is no pagination
	        // to display
	        $next = get_next_posts_link();
	        $prev = get_previous_posts_link();
	        if ($next != null OR $prev != null) {
	        	?>	       
		    	<!-- Pagination -->
		    	<nav class="pagination">
		    		<ul>
		    			<li class="previous"><?php echo $prev; ?></li>
		    			<li class="next"><?php echo $next; ?></li>
		    		</ul>
		    	</nav>
	    		<?php
	        }
	    } else {
	    	get_template_part('loop','none');
	    }
	    ?>
	</section>
	
	<!-- Sidebar -->
	<?php get_sidebar(); ?>
</div>
<!-- /.container -->

<?php
get_footer(); 
?>