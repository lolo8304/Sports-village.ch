<?php
/**
* 404 Not Found Template
*/

get_header();
?>

<div class="container">
	<!-- Content -->
	<section>
		<?php get_template_part('loop','none'); ?>
	</section>
	
	<!-- Sidebar -->
	<?php get_sidebar(); ?>
</div>
<!-- /.container -->

<?php
get_footer(); 
?>