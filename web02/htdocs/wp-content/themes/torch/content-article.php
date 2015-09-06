<?php $archive_year  = get_the_time('Y'); ?>
<?php $archive_month = get_the_time('m'); ?>
<article class="entry-box text-left">
                            <?php 
							global $torch_sidebar;
							$featured_image = "no-img";
							if ( has_post_thumbnail() && $torch_sidebar != "both") {
							$featured_image = "";
								?>
 
								<div class="entry-aside">
									<a href="<?php the_permalink();?>">
                                    <?php the_post_thumbnail("blog");?>
                                    </a>
								</div>
                                <?php }?>

								<div class="entry-main <?php echo $featured_image ;?>">
									<div class="entry-header">
										<div class="entry-meta">
											<div class="entry-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_month_link($archive_year, $archive_month);?>"><?php echo get_the_date("M d, Y");?></a></div>
											<div class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></div> 
											<div class="entry-category"><i class="fa fa-file-o"></i><?php the_category(', '); ?></div>
											<div class="entry-comments"><i class="fa fa-comment"></i><?php  comments_popup_link( __('No comments yet','torch'), __('1 comment','torch'), __('% comments','torch'), 'comments-link', __('No comment','torch'));?></div>
											<?php edit_post_link( __('Edit','torch'), '<div class="entry-edit"><i class="fa fa-pencil"></i>', '</div>', get_the_ID() ); ?> 
										</div>
										<a href="<?php the_permalink();?>"><h1 class="entry-title"><?php the_title();?></h1></a>
										<div class="entry-title-dec"></div>
									</div>
									<div class="entry-summary"><?php the_excerpt();?></div>
									<div class="entry-footer">
										<a href="<?php the_permalink();?>"><div class="entry-more"><?php _e("Read More","torch");?>&gt;&gt;</div></a>
									</div>
								</div>
							</article>