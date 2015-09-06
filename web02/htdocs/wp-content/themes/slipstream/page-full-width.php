<?php
/*
 * Template Name: Full Width
 * Description: A Page Template with no sidebar
 */

get_header();
?>

<div class="container">
	<!-- Content -->
	<section class="no-sidebar">
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
	            		<p>
	            			<span><?php _e('by', 'slipstream'); ?></span>
	            			<?php the_author_posts_link(); ?>
	            			
	            			<span><?php _e('on', 'slipstream'); ?></span>
	            			<?php the_time(get_option('date_format')); ?>
	            		</p>
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
</div>
<!-- /.container -->

<?php
get_footer(); 
?>