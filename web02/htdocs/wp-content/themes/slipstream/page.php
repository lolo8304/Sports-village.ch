<?php
/**
* Default Page Template (2 columns)
*/

get_header();
?>

<div class="container">
	<!-- Content -->
	<section>
		<?php
		// Single Post
	    if (have_posts()) {
	        while (have_posts()) {
	            the_post();
	            ?>	
	            <article>
	            	<!-- Title, Author + Date -->
	            	<header>
	            		<h1><?php the_title(); ?></h1>
	            	</header>
	            	
	            	<?php 
	            	// Post Thumbnail, linked to Post, if it exists
	            	if (has_post_thumbnail()) {
	            		the_post_thumbnail();
	            	}
	            	?>
	            	
	            	<!-- Content -->
	            	<?php 
	            	the_content(); 
	            	wp_link_pages(array(
	            		'before' => '<nav class="pagination page-pagination">',
	            		'after' => '</nav>',
	            		'next_or_number' => 'next',
	            		'nextpagelink' => __('Next Page &raquo;', 'slipstream'),
	            		'previouspagelink' => __('&laquo; Previous Page', 'slipstream'),
	            	));
	            	?>
	            </article>
	            <?php
	            
	            // Comments + Comments Form
	            comments_template();
	        }
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
