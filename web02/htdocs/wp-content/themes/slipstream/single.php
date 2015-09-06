<?php
/**
* Default Single Post Template
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
	            	
	            	<!-- Taxonomies -->
					<footer>
						<ul class="terms">
							<?php
							// Check if there are tags and/or categories
							// If so, output them
							$tags = get_the_tags();
							$terms = get_the_terms(get_the_ID(), 'category');
							if (is_array($tags)) {
								?>
								<li>
									<?php the_tags(); ?>
								</li>
								<?php
							}
							
							if (is_array($terms)) {
								?>
								<li>
									<?php the_terms(get_the_ID(), 'category', __('Categories', 'slipstream').': ', ', '); ?>
								</li>
								<?php
							}
							?>
						</ul>
					</footer> 
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

<?php
get_footer();
?>