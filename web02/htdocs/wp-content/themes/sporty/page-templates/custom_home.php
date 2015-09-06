<?php
/*
 * Template Name: Custom Home Page
 * Description: A home page with featured slider and widgets.
 *
 * @package sporty
 * @since sporty 1.0
 */

get_header(); ?>

	<div class="flex-container">
              <div class="flexslider">
                <ul class="slides">
                <?php
                query_posts(array('category_name' => 'featured', 'posts_per_page' => 3));
                if(have_posts()) :
                    while(have_posts()) : the_post();
                ?>
                  <li>
                    <?php the_post_thumbnail(); ?>
                    <div class="flex-caption">
                    <div class="flex-caption-title">
                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </div>
					<p><?php echo sporty_get_slider_excerpt(); ?>
                    <a href="<?php the_permalink() ?>">...</a></p>
                    </div>
                  </li>
                <?php
                    endwhile;
                endif;
                wp_reset_query();
                ?>
                </ul>
              </div>
	</div>	
    
     <div class="featuretext_top">
			 <h3><?php echo get_theme_mod( 'featured_textbox' ); ?></h3>
		</div>
        
    <div id="primary" class="content-area">
	<div id="content" class="fullwidth" role="main">
  
   <div class="group">
	<div class="col span_2_of_3">         
 <?php query_posts(array('post__in'=>get_option('sticky_posts'))); ?>
	<?php while (have_posts()) : the_post(); ?>
		<article class="sticky">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="blog-image">
				<?php
			if ( has_post_thumbnail() ) {
    $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'featured' );
     echo '<img alt="post" class="imagerct" src="' . $image_src[0] . '">';
}
  			?>
    </div>
                 <?php echo sporty_content(50); ?><div class="stickymore"><a href="<?php the_permalink() ?>"> <?php echo __('More', 'sporty'); ?></a></div>
		</article>
	<?php endwhile; ?>

<?php wp_reset_query(); ?>
    </div>
    
     
   <div class="col span_1_of_3">
   <div class="home_widget">     
     <?php if ( is_active_sidebar( 'right_home_column' ) && dynamic_sidebar('right_home_column') ) : else : ?>
			<?php echo '<h4>' . __('Widget Ready', 'sporty') . '</h4>'; ?>
            <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'sporty') . '</p>'; ?>
            </div>     
	<?php endif; ?>  
    </div>
    
    </div>
    
    
    <div class="section_thumbnails group">
     <?php echo '<h3>' . __('Recent Posts', 'sporty') . '</h3>'; ?>
<!-- LOOP START -->
<?php $the_query = new WP_Query(array(
  'showposts' => 3,
  'post__not_in' => get_option("sticky_posts"),
  ));
 ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
      <div class="col span_1_of_3">
      <ul>
      <!-- THIS DISPLAYS THE POST THUMBNAIL, The array allows the image to has a custom size but is always kept proportional -->
      <li class="post-thumbnail"> <?php the_post_thumbnail( array(70,70) );?></li>
      <!-- THIS DISPLAYS THE POST TITLE AS A LINK TO THE MAIN POST -->
      <li class="blog-lists-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
      <!-- THIS DISPLAYS THE EXCERPT OF THE POST -->
      <li class="blog-lists-content"><?php echo sporty_get_excerpt(); ?><a href="<?php the_permalink() ?>"> <?php echo __('More...', 'sporty'); ?></a></li>
      </ul>
      </div>
    <?php endwhile;?>
<!-- LOOP FINNISH -->
	
    </div>

    
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div>
<?php get_footer(); ?>