<?php
/**
* Default Comments Template
*/

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required()) return;

// Only show this is we have some comments
if (have_comments()) {
    ?>
    <div id="comments">
		<h2><?php _e('Comments', 'slipstream'); ?></h2>
        <?php 
        wp_list_comments(array(
            'avatar_size' => 40,
            'style' => 'div',
            'reply_text' => 'Reply',
        )); 
        
        if (get_comment_pages_count() > 1 AND get_option('page_comments')) {
       		?>
       		<nav class="pagination">
       			<ul>
       				<li class="previous"><?php previous_comments_link(); ?></li>
					<li class="next"><?php next_comments_link(); ?></li>
       			</ul>	
       		</nav>
       		<?php
       	}
		?>
	</div> 
    <?php
}

if (comments_open()) comment_form(); 
?>