<article <?php post_class(); ?>>
	<!-- Title, Author + Date -->
	<header>
		<h1><a href="<?php the_permalink(); ?>" title="<?php _e('Read Full Post', 'slipstream'); ?>"><?php the_title(); ?></a></h1>
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
		?>
		<a href="<?php the_permalink(); ?>" title="<?php _e('Read Full Post', 'slipstream'); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
		<?php
	}
	
	// Excerpt
	the_excerpt();
	?>
	
	<!-- Taxonomy + Continue Reading -->
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
		
		<!-- Continue Reading -->
		<p>
			<a href="<?php the_permalink(); ?>" title="<?php _e('Read Full Post', 'slipstream'); ?>" class="continue">
				<?php _e('Continue Reading', 'slipstream'); ?> &raquo;
			</a>
		</p>
	</footer> 
</article>