<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php wp_head();?>
</head>
<?php
 if(is_home()){
	  $class = "homepage";
	 } elseif(is_404())
	 $class = "404-page";
	 else
	  $class = "blog-list-page";
?>
<body <?php body_class(); ?>>
	<div class="<?php echo $class; ?>">
		<!--Header-->
		<header>
			<div class="container">
				<div class="logo-box text-left">
					 <?php if ( torch_options_array('logo')!="") { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url( torch_options_array('logo') ); ?>" class="site-logo" alt="<?php bloginfo('name'); ?>" />
        </a>
        <?php } ?>
					<div class="name-box">
						<a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
						<span class="site-tagline"><?php echo  get_bloginfo( 'description' );?></span>
					</div>
				</div>
                 <button class="site-search-toggle">
					<span class="sr-only"><?php _e("Toggle navigation","torch");?></span>
					<i class="fa fa-search fa-2x"></i>
				</button>
				<button class="site-nav-toggle">
					<span class="sr-only"><?php _e("Toggle navigation","torch");?></span>
					<i class="fa fa-bars fa-2x"></i>
				</button>
                
				<form role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-form">
					<div>
						<label class="sr-only"><?php _e("Search for","torch");?>:</label>
						<input type="text" name="s" id="s" value="" placeholder="<?php _e("Search","torch");?>...">
						<input type="submit" value="">
					</div>
				</form>
               
				<nav class="site-nav" role="navigation">
					<?php 
					 wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
					?>
				</nav>
			</div>
		</header>