<?php
/**
 * The Template for displaying 404 Page not Found .
 *
 * @since torch 1.0.0
 */

get_header(); ?>
<div class="breadcrumb-box">
            <?php torch_get_breadcrumb();?>
        </div>
<div class="blog-detail right-aside">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <section class="blog-main text-center" role="main">
                            <article class="post-entry text-left">
                                <div class="entry-main">
                                   <?php 
									$page_404_content = torch_options_array('page_404_content');
									echo $page_404_content ;
									?>
                                </div>
                            </article>
                        </section>
                    </div>
                    <div class="col-md-3">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
       <?php get_sidebar( '404' ); ?>
                                
                            </div>
                        </aside>
                    </div>
                </div>
            </div>  
        </div>

<?php get_footer(); ?>