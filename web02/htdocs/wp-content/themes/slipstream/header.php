<?php
/**
* Site wide header
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>    
    <!-- Metadata -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="HandheldFriendly" content="true" />
	<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
     
    <!-- Title -->
    <title><?php wp_title('|', true, 'right'); ?></title>
    
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
   
    <?php wp_head(); ?>  
</head>

<body <?php body_class(); ?>>
	<!-- Header -->
	<header id="header">
		<div class="container">
			<!-- Navigation Menu Button (Responsive) -->
			<div id="mobile-header">
				<a id="responsive-menu-button" href="#sidr-main">&#9776;</a>
			</div>
			
			<!-- Site Title -->
			<?php
			$image = get_header_image();
			if (!empty($image)) {
				?>
				<a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" class="header-image">
					<img src="<?php echo $image; ?>" />
				</a>
				<?php
			} else {
				?>
				<h1><a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
				<?php
			}
			?>

			<!-- Search Form -->
			<?php get_search_form(); ?>
			
			<!-- Navigation -->
			<div id="navigation">
	            <nav>
			    	<?php
			    	if (has_nav_menu('header')) {
				    	wp_nav_menu(array(
			            	'container' => '', 
			                'theme_location' => 'header', 
			                'menu_class' => '', 
			                'echo' => true,
			            ));
		            }
		            ?>
			    </nav>
		    </div>
		</div>
	</header>
	
	<!-- Content Area -->
	<div id="main">