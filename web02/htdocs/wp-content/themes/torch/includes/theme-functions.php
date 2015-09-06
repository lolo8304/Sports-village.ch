<?php

 	/*	
	*	get background 
	*	---------------------------------------------------------------------
	*/
function torch_get_background($args){
$background = "";
 if (is_array($args)) {
	if (isset($args['image']) && $args['image']!="") {
	$background =  "background:url(".esc_url( $args['image'] ). ")  ".$args['repeat']." ".$args['position']." ".$args['attachment'].";";
	}
	else
	{
	if(isset($args['color']) && $args['color'] !=""){
	$background = "background:".$args['color'].";";
	}
	}
	}
return $background;
}


	
	// get breadcrumbs
 function torch_get_breadcrumb(){
   global $post,$wp_query ;
    $postid = isset($post->ID)?$post->ID:"";
	
   $show_breadcrumb = "";
   if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) { 
    $postid = $wp_query->get_queried_object_id();
   }
  
   if(isset($postid) && is_numeric($postid)){
    $show_breadcrumb = get_post_meta( $postid, '_torch_show_breadcrumb', true );
	}
	if($show_breadcrumb == 'yes' || $show_breadcrumb==""){

  echo '<div class="container">';
  if ( is_singular() ) {
	
  echo '<div class="breadcrumb-title">'.$post->post_title.'</div>';
  }
  echo '<div class="breadcrumb-nav">'; 
               breadcrumb_trail(array("before"=>"","show_browse"=>false));
      echo '</div>    
                <div class="clearfix"></div>            
            </div>';
           
	}
	   
	}
	
	
/*
*  page navigation
*
*/
function torch_native_pagenavi($echo,$wp_query){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => '&laquo; ',
    'next_text' => ' &raquo;'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
    echo '<div class="page_navi">'.paginate_links($pagination).'</div>'; 
	}else
	{
	
	return '<div class="page_navi">'.paginate_links($pagination).'</div>';
	}
}
   
    //// Custom comments list
   
   function torch_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   
   <li  <?php comment_class("comment"); ?> id="comment-<?php comment_ID() ;?>">
                                	<article class="comment-body">
                                    	<div class="comment-avatar"><?php echo get_avatar($comment,'52','' ); ?></div>
                                        <div class="comment-box">
                                            <div class="comment-info"><?php printf(__('%s <span class="says">says:</span>','torch'), get_comment_author_link()) ;?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','torch'), get_comment_date(), get_comment_time()) ;?></a>  <?php edit_comment_link(__('(Edit)','torch'),'  ','') ;?></div>

 <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','torch') ;?></em>
         <br />
      <?php endif; ?>
     <div class="comment-content"><?php comment_text() ;?>
      <div class="reply-quote">
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
			</div>
       </div>
    </div></article>

<?php
        }
		
 function torch_get_default_slider(){
	global $allowedposttags ;
	$controller   = '';
	$slideContent = '';
	
	$slide_time       = torch_options_array("slide_time");
	$slide_height     = torch_options_array("slide_height");
	$slide_height     = $slide_height==""?"":"height:".$slide_height.";";
	$slide_time       = is_numeric($slide_time)?$slide_time:"5000";
		  
	$return = '<section class="homepage-slider"><div id="carousel-torch-generic" style="'.esc_attr( $slide_height ).'" class="carousel slide" data-interval="'.absint( $slide_time ).'" data-ride="carousel">';
	 for($i=1;$i<=5;$i++){
	$active = '';
	// $title = torch_options_array('torch_slide_title_'.$i);
	 $text     = torch_options_array('torch_slide_text_'.$i);
	 $image    = torch_options_array('torch_slide_image_'.$i);
	 $link     = torch_options_array('torch_slide_link_'.$i);
	 $btn_text = torch_options_array('torch_slide_btn_text_'.$i);
	
		   
	 if($i==1) $active     = 'active';

	 
	 if(isset($image) && strlen($image)>10){
		 $controller   .= '<li data-target="#carousel-torch-generic" data-slide-to="'.($i-1).'" class="'.$active.'"><span>'.$i.'</span></li>';
			
		 $slideContent .= '<div class="item '.$active.'">';
         $slideContent .= '<img src="'.esc_url($image).'" alt="" />';
         $slideContent .= '<div class="carousel-caption">';
		 $slideContent .= '<div class="caption-text">';
		 $slideContent .= wp_kses( $text, $allowedposttags  );
		 $slideContent .= '</div>';
		 if($link != "")
		 $slideContent .= '<a href="'.esc_url($link).'"><button>'.esc_html($btn_text).'</button></a>';
		 $slideContent .= '</div>';
		 $slideContent .= '</div>';
		 }
		
	}
	     $return .= '<ol class="carousel-indicators">'. $controller .'</ol>';
		 $return .= '<div class="carousel-inner">'. $slideContent .'</div>';
		 
		 $return .= '<a class="left carousel-control" href="#carousel-torch-generic" data-slide="prev">
						<span class="fa fa-angle-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-torch-generic" data-slide="next">
						<span class="fa fa-angle-right"></span>
					</a>';
		$return .= '</div></section>';

        return $return;
   }
   

 
  function torch_enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
	
			$tag = "<link rel='stylesheet' id='".esc_attr($handle)."' $title href='".esc_attr($href)."' type='text/less' media='".esc_attr($media)."' />";
		}
		return $tag;
	}
	add_filter( 'style_loader_tag', 'torch_enqueue_less_styles', 5, 2);
	
	
add_action( 'optionsframework_sidebar','torch_options_panel_sidebar' );

/**
 * torch admin sidebar
 */
function torch_options_panel_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
	    	<div class="postbox">
	    		<h3><?php esc_attr_e( 'Quick Links', 'torch' ); ?></h3>
      			<div class="inside"> 
		          <ul>
                   <li><a href="<?php echo esc_url( 'http://www.mageewp.com/torch-theme.html' ); ?>" target="_blank"><?php _e('Upgrade to Pro','torch');?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/themes/' ); ?>" target="_blank"><?php _e('MageeWP Themes','torch');?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/documents/tutorials' ); ?>" target="_blank"><?php _e('Tutorials','torch');?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/documents/faq/' ); ?>" target="_blank"><?php _e('FAQ','torch');?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/knowledges/' ); ?>" target="_blank"><?php _e('Knowledge','torch');?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/forums/torch-theme/' ); ?>" target="_blank"><?php _e('Support Forums','torch');?></a></li>
                  </ul>
      			</div>
	    	</div>
	  	</div>
	</div>
    <div class="clear"></div>
<?php
} 
 
 function torch_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( ' Page %s ', 'torch' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'torch_wp_title', 10, 2 );

if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function torch_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'torch_slug_render_title' );
}



  function torch_title( $title ) {
  if ( $title == '' ) {
  return 'Untitled';
  } else {
  return $title;
  }
  }
  add_filter( 'the_title', 'torch_title' );


	function torch_favicon()
	{
	    $url =  torch_options_array('favicon');
	
		$icon_link = "";
		if($url)
		{
			$type = "image/x-icon";
			if(strpos($url,'.png' )) $type = "image/png";
			if(strpos($url,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($url).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}
	add_action( 'wp_head', 'torch_favicon' );