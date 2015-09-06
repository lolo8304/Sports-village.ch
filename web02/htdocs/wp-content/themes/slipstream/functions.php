<?php
/**
* Theme specific functionality
*/
class SlipstreamThemeFunctionality { 
    /**
    * Construct. Registers support for image thumbnails, navigation menus and sidebars, and
    * sets up the theme's required action and filter hooks.
    */
    function SlipstreamThemeFunctionality() {
    	global $content_width;
    	
        // Theme Details
        $this->theme = new stdClass;
        $this->theme->name = 'slipstream';
        $this->theme->folder = 'slipstream';
        
        // Content Width
        if (!isset($content_width)) $content_width = 600;
        
        // Adds RSS feed links to <head> for posts and comments.
		add_theme_support('automatic-feed-links');

		// Output HTML5
		add_theme_support('html5', array(
			'search-form', 
			'comment-form', 
			'comment-list'
		));
         
        // Custom Background Support
        add_theme_support('custom-header', array(
        	'width' => 290,
        	'height' => 80,
        	'default-text-color' => '#ffffff',
        ));
        add_theme_support('custom-background', array(
			'default-color' => 'ececec',
			'default-image' => get_template_directory_uri().'/images/background.png',
		));
         
        // Image Thumbnail Sizes
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(600, 180, true); // Default
        add_image_size('about-box-widget', 288, 288, true); // About Box Widget
        
        // Navigation Menus
        add_theme_support('nav-menus');
        register_nav_menus(array(
        	'header' => __('Header Menu', 'slipstream'),
        ));
        
        // Sidebars
        if (function_exists('register_sidebar')) {
            // Sidebar Area
            register_sidebar(array(
            	'name' => __('Sidebar', 'slipstream'),
            	'id' => 'slipstream-sidebar',
            	'description' => __('Appears on the right hand side of your Posts and Pages', 'slipstream'),
            )); 

            // 3 x Footer Areas
            register_sidebar(array(
            	'name' => __('Footer Left Column', 'slipstream'),
            	'id' => 'slipstream-footer-1',
            	'description' => __('Appears in the footer left column of your Theme', 'slipstream'),
            ));
            register_sidebar(array(
            	'name' => __('Footer Center Column', 'slipstream'),
            	'id' => 'slipstream-footer-2',
            	'description' => __('Appears in the footer center column of your Theme', 'slipstream'),
            ));
            register_sidebar(array(
            	'name' => __('Footer Right Column', 'slipstream'),
            	'id' => 'slipstream-footer-3',
            	'description' => __('Appears in the footer right column of your Theme', 'slipstream'),
            ));
        }

        // Hooks
        add_action('widgets_init', array(&$this, 'registerWidgets'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminScriptsAndCSS'));
       	add_action('wp_enqueue_scripts', array(&$this, 'frontendScriptsAndCSS'));
       	add_action('after_setup_theme', array(&$this, 'loadLanguageFiles'));
    }
    
    /**
    * Registers theme specific widgets included in this file
    */
    function registerWidgets() {
    	// About Box
    	register_widget('SlipstreamAboutBoxWidget');
    }
    
    /**
    * Enqueue Admin JS + CSS
    */
    function adminScriptsAndCSS() {
    	// JS
    	wp_enqueue_media();
		wp_enqueue_script($this->theme->name.'-media-manager', get_template_directory_uri().'/js/media-manager.js');
		
    	// CSS
		wp_enqueue_style($this->theme->folder.'-admin', get_template_directory_uri().'/css/admin.css');
		add_editor_style('css/editor-style.css');
    }
    
    /**
    * Load jQuery from the Google CDN for the frontend web site, as well as
    * any other frontend scripts we might need.
    */
    function frontendScriptsAndCSS() {
    	// Header JS
        wp_enqueue_script('jquery');
        wp_enqueue_script('comment-reply');
        
        // Footer JS
        wp_enqueue_script($this->theme->name.'-sidr', get_template_directory_uri().'/js/jquery.sidr.min.js', false, null, false);
        wp_enqueue_script($this->theme->name.'-ui', get_template_directory_uri().'/js/min/ui-ck.js', false, null, true); 
		
		// Header CSS
		wp_enqueue_style($this->theme->name.'-lato', '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic');
		wp_enqueue_style($this->theme->name.'-css', get_stylesheet_directory_uri().'/css/style.css');
		wp_enqueue_style($this->theme->name.'-style', get_stylesheet_directory_uri().'/style.css'); /* Support for child themes */
	}
	
	/**
	* Loads available .mo language files in the languages theme folder
	*/
	function loadLanguageFiles() {
		load_theme_textdomain('slipstream', get_template_directory().'/languages');
	}
}
$slipstreamThemeFunctionality = new SlipstreamThemeFunctionality();

/**
* Widget: About Box Widget
*/ 
class SlipstreamAboutBoxWidget extends WP_Widget {
    /**
    * Constructor.  Sets up the widget, and adds it to the WP_Widget class
    */
    function __construct() {
    	// Setup Widget
    	parent::__construct(
	 		'slipstream_about_box',
			__('Slipstream: About', 'slipstream'),
			array(
				'classname' => 'widget_slipstream_about_box',
				'description' => __('Add an about box comprising of full width image, title and text.', 'slipstream')
			)
		);
		
		add_image_size('slipstream-about-box-widget', 288, 288, true);
    }
    
    /**
    * Displays the front end widget
    * 
    * @param string $args Native Wordpress Vars
    * @param string $instance Configurable jobs
    */
    function widget($args, $instance) { 
    	// Check if any settings have been defined
    	// If not, and the logged in WordPress User has edit_theme_options capabilities (meaning they
    	// can edit widgets), show them a nice notice to go and fix this problem
    	
    	if (empty($instance) OR !array_filter($instance)) {
    		$user = wp_get_current_user();
    		if (isset($user->allcaps['edit_theme_options']) AND $user->allcaps['edit_theme_options'] == 1) {
    			?>
    			<li class="widget widget_social_icons">
    				<?php _e('You need to configure the Slipstream About Box widget.', 'slipstream'); ?>
    				<a href="<?php echo admin_url(); ?>widgets.php"><?php _e('Configure Now', 'slipstream'); ?></a>
    			</li>
    			<?php
    			return;	
    		}
    		
    	} 
    	
    	// If here, OK to show the widget as it's been configured
    	?>
 		<li class="widget widget_slipstream_about_box">
 			<?php 
 			// Image
 			if (!empty($instance['image'])) {
 				$imageAtts = wp_get_attachment_image_src($instance['image'], 'slipstream-about-box-widget');
 				if (is_array($imageAtts)) {
	 				?>
	 				<div class="image">
	 					<img src="<?php echo $imageAtts[0]; ?>" width="<?php echo $imageAtts[1]; ?>" height="<?php echo $imageAtts[2]; ?>" />
	 				</div>
	 				<?php
 				}
 			}
 			?>
 			<div class="textwidget">
	 			<?php
	 			if (!empty($instance['title'])) { 
	 				$title = apply_filters('widget_title', $instance['title']);
	 				echo $args['before_title'].$title.$args['after_title'];
	 			}
	 			if (!empty($instance['text'])) { 
	 				?>
	 				<p><?php echo $instance['text']; ?></p>
	 				<?php 
	 			}
		 		?>
	 		</div>
		</li>
		<?php
    }

    /**
    * Process the new settings before they're sent off to be saved
    * 
    * @param array $new_instance Array of settings we're about to process, before saving
    * @param array $old_instance Old Settings
    * @return array New Settings to be saved
    */
    function update($new_instance, $old_instance) {  
    	return $new_instance;
    }
    
    /**
    * Creates the edit form for the widget
    * 
    * @param array $instance Current Settings
    */
    function form($instance) {
    	// If an existing image is specified, get it baesd on the given attachment ID
    	if (!empty($instance['image'])) {
    		$imageAtts = wp_get_attachment_image_src($instance['image'], 'about-box-widget');
    	}
    
    	// Image Upload
    	$randID = mt_rand();
    	echo ('	<p>
					<input type="hidden" id="'.$randID.'-attachmentID" name="'.$this->get_field_name('image').'" value="'.(isset($instance['image']) ? $instance['image'] : '').'" />');
    	
		if (get_bloginfo('version') < '3.5') {
			echo ('	<input type="button" id="'.$randID.'" class="upload button" value="'.__('Upload').'" />');
		} else {
			echo ('
				<span class="'.$randID.'-attachmentID">'.
					((!empty($instance['image']) AND is_array($imageAtts)) ? '<img src="'.$imageAtts[0].'" width="100%" />' : '').'
				</span>
				<span class="wp-media-buttons">
					<a href="#" class="button insert-media-url add_media '.$randID.'-attachmentID" data-editor="'.$randID.'-attachmentID">
						<span class="wp-media-buttons-icon"></span>
						'.__('Choose Image', 'slipstream').'
					</a>
					<a href="#" class="button button-red delete'.(empty($instance['image']) ? ' hidden' : '').'" data-editor="'.$randID.'-attachmentID">
						'.__('Delete', 'slipstream').'
					</a>
				</span>');	
		}
		
		echo ('	</p>
		
				<p>
                    <label for="'.$this->get_field_id('title').'">
                        '.__('Title', 'slipstream').':
                        <input type="text" name="'.$this->get_field_name('title').'" id="'.$this->get_field_id('title').'" value="'.(isset($instance['title']) ? $instance['title'] : '').'" class="widefat" />
                    </label>
                </p>
                <p>                    
                    <textarea name="'.$this->get_field_name('text').'" id="'.$this->get_field_id('text').'" class="widefat" style="height:150px;">'.(isset($instance['text']) ? trim($instance['text']) : '').'</textarea>
                </p>');
    }
} // Close SlipstreamAboutBoxWidget
?>