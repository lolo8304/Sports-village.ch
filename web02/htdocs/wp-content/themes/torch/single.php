<?php
/**
 * The Template for displaying single post.
 *
 * @since torch 1.0.0
 */

get_header(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if (have_posts()) :?>
<?php	while ( have_posts() ) : the_post();
        $torch_sidebar      = get_post_meta( $post->ID, '_torch_layout', true );
		$torch_sidebar      = $torch_sidebar==""?"right":$torch_sidebar;
		$column_class_one   = ""; 
		$column_class_two   = ""; 
		$column_class_three = ""; 
		switch($torch_sidebar){
			case "left":
			$column_class_one   = "col-md-9 col-md-push-3"; 
			$column_class_two   = "col-md-3 col-md-pull-9"; 
			$column_class_three = ""; 
			break;
			case "right":
			$column_class_one   = "col-md-9"; 
			$column_class_two   = ""; 
			$column_class_three = "col-md-3";
			break;
			case "both":
			$column_class_one   = "col-md-6 col-md-push-3"; 
			$column_class_two   = "col-md-3 col-md-pull-6"; 
			$column_class_three = "col-md-3"; 
			break;
			case "none":
			$column_class_one   = "col-md-12"; 
			$column_class_two   = ""; 
			$column_class_three = "";
			break;
			default:
			$column_class_one   = "col-md-9"; 
			$column_class_two   = ""; 
			$column_class_three = "col-md-3";
			break;
			
			}
?>
<div class="breadcrumb-box">
            <?php torch_get_breadcrumb();?>
        </div>
        <div class="blog-detail right-aside">
            <div class="container">
                <div class="row">
                    <div class="<?php echo $column_class_one;?>">
                        <section class="blog-main text-center" role="main">
                            <article class="post-entry text-left">
                                <div class="entry-main">
                                    <div class="entry-header">
                                        <div class="entry-meta">
                                            <div class="entry-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_day_link('', '', '');?>"><?php echo get_the_date("M d, Y");?></a></div>
                                            <div class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></div> 
                                            <div class="entry-category"><i class="fa fa-file-o"></i><?php the_category(', '); ?></div>
                                            <div class="entry-comments"><i class="fa fa-comment"></i>
                                            <?php  comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'No comment');?>
                                             </div>
                                           <?php edit_post_link( __('Edit','torch'), '<div class="entry-edit"><i class="fa fa-pencil"></i>', '</div>', get_the_ID() ); ?> 
                                        </div>
                                        <h1 class="entry-title"><?php the_title();?></h1>
                                        <div class="entry-title-dec"></div>
                                    </div>
                                    <div class="entry-content">
                                       <?php the_content();?>	
                                       <?php  wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'torch' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                                    </div>
                                </div>
                            </article>
                            <div class="comments-area text-left">
                             <?php
									echo '<div class="comment-wrapper">';
									comments_template(); 
									echo '</div>';
                                  ?>    
                            </div>
                        </section>
                    </div>
                       <?php if($torch_sidebar == "left" || $torch_sidebar == "both"){?>
					<div class="<?php echo $column_class_two;?>">
						<aside class="blog-side left text-left">
							<div class="widget-area">
									<?php get_sidebar("postleft");?>
							</div>
						</aside>
					</div>
                    <?php }?>
                    <?php if($torch_sidebar == "right" || $torch_sidebar == "both"){?>
					<div class="<?php echo $column_class_three;?>">
						<aside class="blog-side right text-left">
							<div class="widget-area">
						<?php get_sidebar("postright");?>
							</div>
						</aside>
					</div>
                    <?php }?>
                </div>
            </div>  
        </div>

<?php endwhile;?>
<?php endif;?>
</div>
<?php get_footer(); ?>