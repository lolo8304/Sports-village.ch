<?php 
// Generate the Tab Slide settings page
if ( !class_exists('Tab_Slide_Pro_Settings') ) {	
	class Tab_Slide_Pro_Settings {
		var $instances= array();
		public function __construct() {
			global $tab_slide_pro;
			$this->instances = $tab_slide_pro->plugin_options['instances'];
			if ( empty($this->instances) ) {
				$tab_slide_pro->load_default_themes();
				$this->instances = $tab_slide_pro->plugin_options['instances'];
			}
		}
		function init() {
		}
		function get_radio( $option, $class, $value, $id ) { 
			
			?><input type="radio" name="new_opt[<?php echo $id ?>][<?php echo $option ?>]" value="<?php echo $value ?>" <?php if ($class) { echo "class='$class'";} ?> <?php checked($value,$this->instances[$id][$option]); ?> />
		
		<?php
		}
		function get_checkbox( $option, $class, $value, $id  ) {
			?>
			<input type="hidden" name="new_opt[<?php echo $id ?>][<?php echo $option ?>]" value='0' />
			<input type="checkbox" name="new_opt[<?php echo $id ?>][<?php echo $option ?>]" id="<?php $option ?>" value="<?php echo $value ?>" <?php if ($class) { echo "class='$class'";} ?> <?php checked($this->instances[$id][$option]); ?>/>
		<?php
		}
		function get_input( $option, $class, $max_length, $size, $id, $type = false ) {
			if ($type) {
				settype($value, $type);
			}
			?><input name="new_opt[<?php  echo $id ?>][<?php echo $option ?>]" value="<?php echo $this->instances[$id][$option] ?>" id="<?php echo $option ?>" <?php if ($class) { echo "class='$class'";} ?> <?php if ($max_length) { echo "maxlength='$max_length'";} ?> <?php if ($size) { echo "size='$size'";} ?> />
		<?php
		}
		function tab_slide_pro_options_page() {
			global $tab_slide_pro;

			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '0'; 
			if ( !isset($this->instances[$active_tab])) {
				$active_tab = 0;
			}
			?>
			<script language="javascript" type="text/javascript">
				var activeId = <?php echo $active_tab ?>;
			</script>
			<div class="wrap">
				
				<div id="header-wrapper">
			    <div class="tabslide-icon"></div>
		      <h3>Tab Slide Pro</h3>
				  <select class="nav-tab-wrapper">
				  <?php	
				  foreach($this->instances as $id => $options) { ?>
					  <option value="<?php echo $id; ?>" <?php echo $active_tab == $id ? 'selected="selected"' : ''; ?>><?php echo $this->instances[$id]['name'] ?></option>  
				  <?php } ?>
				  </select>

				  <div id='instance-menu'>
					  <ul class="subsubsub">
						  <li>
						    <a href="javascript:void(0)" class="save-settings" alt="Save this instance"><?php _e('Save', 'tab-slide-pro') ?> </a>
							  <a href="#" class="instance_menu_item" onClick="clone_this_instance('<?php echo $active_tab; ?>')" alt="Clone this instance"><?php _e('Clone', 'tab-slide-pro') ?> </a>
						  </li>
						  <li><?php $instance = $tab_slide_pro->get_plugin_option('instances'); ?>
							  <a href="#" class="instance_menu_item hidden" onClick="refresh_instance_css('<?php echo $active_tab; ?>')" alt="Clone this instance">Refresh </a>
						  </li>
						  <li>
						  <?php if($active_tab > 1) { ?>
							  <a href="#" class="instance_menu_item" onClick="delete_this_instance('<?php echo $active_tab; ?>')" alt="Delete this instance"> <?php _e('Delete', 'tab-slide-pro') ?> </a>
						  <?php } ?>
						  </li>
						  <li>
							  <?php if($this->instances[$active_tab]['list_pick'] === 'disabled') { ?>
								  <a href="#" class="button-primary" id="enable<?php echo $active_tab; ?>" onClick="enable_this_instance('<?php echo $active_tab; ?>')"> <?php _e('Enable', 'tab-slide-pro') ?> </a>
							  <?php } else { ?>
								  <a href="#" class="instance_menu_item" id="disable<?php echo $active_tab; ?>" onClick="disable_this_instance('<?php echo $active_tab; ?>')"> <?php _e('Disable', 'tab-slide-pro') ?> </a><?php echo '&nbsp;  <span class="active_status">Active Slide ID: '. $active_tab . '</span>' ?>
						  <?php } ?>
						  </li>
					  </ul>
				  </div>
          <div id="help">
            <a href="javascript:void(0)" class="instance_menu_item help-descriptions" >Help</a>
            <a href="#" class="instance_menu_item about" >About</a>
          </div>
			  </div>
				
		    <h2></h2>
				<div class="newline sections">
					<ul class="subsubsub">
						<li><a class="general current" href="#"><?php _e('General', 'tab-slide-pro') ?> </a> |</li>
						<li><a href="javascript:void(0)" class="advanced"><?php _e('Advanced', 'tab-slide-pro') ?></a> </li>
					</ul>
				</div>
				<?php $msg = null;
					if( array_key_exists( 'updated', $_GET ) && $_GET['updated']=='true' ) { $msg = __('Settings Saved', 'tab_slide'); }
				?>
				<?php do_action('save_tab_slide_settings', $active_tab); ?>
				<form action="options.php" method="post">
					<?php settings_fields( $tab_slide_pro->options_group ); ?>
					<?php $this->get_form_content($active_tab); ?>
					<?php echo apply_filters('tab_slide_settings_form', '', $active_tab) ?>
					<input id='current_id' type="hidden" value="<?php echo $active_tab ?>" />
					<input name="info_update" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
				</form>
				
				
				<div id="overlay" class="hidden"></div>
				<div id="about" class="hidden"> 
					<div id="logo"></div>
					<div id="close_about">&#215</div>
					<h2><em><?php _e('Tab Slide Pro v', 'tab-slide-pro') ?><?php echo $tab_slide_pro->get_plugin_option('version'); ?></em></h2>
					<div id="about_content">
						<p><?php _e('Your API KEY:', 'tab-slide-pro') ?></p>
<p><input type="text" id="api-key" style="width:75%;" value="<?php echo $tab_slide_pro->get_plugin_option('api_key'); ?>"/><button id="save-api-key" type="button"><?php _e('Save', 'tab-slide-pro') ?></button> </p>
						<p><?php _e('Thank you for  making the continuous development of Tab Slide Pro possible.', 'tab-slide-pro') ?> </p>
						<p><?php _e('If you have any questions you can visit the', 'tab-slide-pro') ?> <a href="http://store.zoranc.co/support/" target="_blank"><?php _e('support forum', 'tab-slide-pro') ?></a>.
						</p>
<p><?php _e('Note: You will have to be logged in with your credentials so you can gain access to the forum. You should have recieved the email containing your credentials and the api key shortly after purchase', 'tab-slide-pro') ?></p>
					</div>
					
				</div>
			</div>
			 
		<?php
		}
		/* 
		 * Adds Settings page for Tab Slide.
		 */
		function get_form_content( $active_id ) {
			global $tab_slide_pro ?>
			<div id="general">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong><?php _e('Slide Name', 'tab-slide-pro') ?></strong>
					</th>
					<td>
						<?php $this->get_input ( 'name', '', '23', '22', $active_id); ?>
					</td>
				</tr>
				<?php echo apply_filters('tab_slide_settings_general_before_slide_startup_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('Startup Settings', 'tab-slide-pro') ?></strong>
					</th>
					<td>	 
						<p>
							<label for="tab_slide_position">
								<?php _e('', 'tab-slide-pro'); ?>
								<?php $this->get_radio('tab_slide_position', '', 'left' , $active_id ); ?><?php _e('Left', 'tab-slide-pro') ?>
								<?php $this->get_radio('tab_slide_position', '', 'right', $active_id ); ?><?php _e('Right', 'tab-slide-pro') ?>
							</label>
							<label for="show_on_load" class='newline'>
								<?php $this->get_checkbox('show_on_load', 'show_on_load', 1, $active_id ); ?>
								<?php _e('Start in open tab slide view', 'tab-slide-pro') ?>
							</label> 
							<span class="description hidden"><?php _e('Determines whether the tab slide content is initially shown when the page is loaded.', 'tab-slide-pro') ?></span>
						</p>
						<div id='autoopen_timer'>
							<label for="enable_open_timer">
								<?php $this->get_checkbox ('enable_open_timer', 'enable_timer', 1, $active_id); ?>
								<?php _e('Enable Auto-Open Timer', 'tab-slide-pro') ?>
							</label>
						</div>
						<div id='autohide_timer'>
							<label for="enable_timer">
								<?php $this->get_checkbox ('enable_timer', 'enable_timer', 1, $active_id); ?>
								<?php _e('Enable Auto-Hide Timer', 'tab-slide-pro') ?>
							</label>
						</div>
						<div id='timer'>
							<label for="timer">
								<?php _e('Wait for:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'timer', '', '6', '5', $active_id, 'float'); ?><?php _e('seconds', 'tab-slide-pro') ?>
						</div>
					</td>
				</tr>
        <?php echo apply_filters('tab_slide_settings_general_before_slide_content_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('Slide Content Settings', 'tab-slide-pro') ?></strong>
					</th>
					<td>
						<p>
							<div class="peripheral">
								<label for="borders">
									<?php _e('Use Borders:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_radio ( 'borders' , 'no_borders', 0, $active_id ); ?><?php _e('No', 'tab-slide-pro') ?>
								<?php $this->get_radio ( 'borders' , 'yes_borders', 1, $active_id ); ?><?php _e('Yes', 'tab-slide-pro') ?>
								<span class="border_size">										
									<label for="border_size">
										<?php _e('-> Offset closed slide by:', 'tab-slide-pro') ?>
									</label>
									<?php $this->get_input ( 'border_size', 'border_size', 4, 4, $active_id, 'int' ); ?>px
								</span>
							</div><div></div>
							<label for="open_width">
								<?php _e('Slide width:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'open_width', '', 5, 2, $active_id ); ?>
								
							<label for="open_height">
								<?php _e('Slide height:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'open_height', '', 5, 2, $active_id ); ?>
							
							<label for="window_unit">
								<?php $this->get_radio ( 'window_unit', '', 'px', $active_id ); ?>px
								<?php $this->get_radio ( 'window_unit', '', '%', $active_id ); ?>%
							</label> 
							<div class="peripheral">
								<label for="open_top">
									<?php _e('Vertical position from top:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_input ( 'open_top', '', 5, 1, $active_id, 'int' ); ?>%
							</div>
							<span class="description hidden"><?php _e('The size and vertical positioning settings.<br /> Width and Height values can be dealt with either in percentages or pixels.', 'tab-slide-pro') ?></span>
						</p>
						<p>
							<label for="template_pick">
								<?php _e('Template:', 'tab-slide-pro') ?>
							</label>
							<input type=hidden name="new_opt[<?php  echo $active_id ?>][template_pick]"  value="<?php  echo $this->instances[$active_id]['template_pick'] ?>" id="template_pick" size="90">
								<select name="new_opt[<?php echo $active_id; ?>][template_select]"  id='template_select'>
									<option id='subscribe' value='Subscribe' <?php if ($this->instances[$active_id]['template_pick'] == 'Subscribe') echo " selected"; ?>><?php _e('Subscribe', 'tab-slide-pro') ?></option>
									<option id='wplogin' value='WPLogin' <?php if ($this->instances[$active_id]['template_pick'] == 'WPLogin') echo " selected"; ?>><?php _e('WPLogin', 'tab-slide-pro') ?></option>
									<option id='widget' value='Widget' <?php if ($this->instances[$active_id]['template_pick'] == 'Widget') echo " selected"; ?>><?php _e('Widget', 'tab-slide-pro') ?></option>
									<option id='post' value='Post' <?php if ($this->instances[$active_id]['template_pick'] == 'Post') echo " selected"; ?>><?php _e('Post', 'tab-slide-pro') ?></option>
									<option id='iframe' value='iFrame' <?php if ($this->instances[$active_id]['template_pick'] == 'iFrame') echo " selected"; ?>><?php _e('iFrame', 'tab-slide-pro') ?></option>
									<option id='picture' value='Picture' <?php if ($this->instances[$active_id]['template_pick'] == 'Picture') echo " selected"; ?>><?php _e('Picture', 'tab-slide-pro') ?></option>
									<option id='video' value='Video' <?php if ($this->instances[$active_id]['template_pick'] == 'Video') echo " selected"; ?>><?php _e('Video', 'tab-slide-pro') ?></option>
									<option id='custom' value='Custom' <?php if ($this->instances[$active_id]['template_pick'] == 'Custom') echo " selected"; ?>><?php _e('Custom', 'tab-slide-pro') ?></option>
								</select>
							</input>
						</p>
						<div id="Widget">
							<span class="description hidden"><?php _e('Tab Slide Pro Widget Area Enabled.', 'tab-slide-pro') ?></span>
						</div>
						<div id="Post">
							<label for="post">
								<?php _e('Post ID: ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'post_id', '', '', 2, $active_id ); ?>
							<span class="description hidden"><?php _e('example: 2', 'tab-slide-pro') ?></span>
						</div>
						<div id="iFrame">
							<label for="iframe_url">
								<?php _e('iFrame Url: ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'iframe_url', '', '', '', $active_id ); ?>
							<span class="description hidden"><?php _e('example: http://www.google.com/', 'tab-slide-pro') ?></span>
						</div>
						<div id="Picture">
							<label for="picture_url">
								<?php _e('Picture Url: ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'picture_url', '', '', '', $active_id ); ?>
							<span class="description hidden"><?php _e('example: http://www.google.com/picture.jpg', 'tab-slide-pro') ?></span>
						</div>
						<div id="Video">  
							<label for="video_url">
								<?php _e('Video Url: ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'video_url', '', '', '', $active_id ); ?>
							<span class="description hidden"><?php _e('example: http://www.youtube.com/v/9yl_XPkcTl4 <br/ >Note: Video URL format', 'tab-slide-pro') ?></span>
						</div>
						<div id="Custom">
							<label for="window_url">
								<?php _e('Window Url Path:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'window_url', '', '', '', $active_id ); ?>
							<span class="description hidden"><?php _e('example: http://www.yoursite.com/path_to/target.php', 'tab-slide-pro') ?></span>
						</div>
					</td>
				</tr>
				
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('Background Settings', 'tab-slide-pro') ?></strong></th>
					<td>
						<p>
							<label for="background">
								<?php _e('Background (Path or Color):', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'background', '', '', 58, $active_id ); ?>	
							<span class="description hidden"><?php _e('You can use the color picker or simply use the image location eg. http://www.yoursite.com/background.jpg', 'tab-slide-pro') ?></span>
							<div id="bgcolorpicker"></div>
						</p>
						<p>
							<label for="opacity">
								<?php _e('Opacity:', 'tab-slide-pro') ?>
							</label>
								
							<input type="range"  min="0" max="100" name="new_opt[<?php  echo $active_id ?>][opacity]" value="<?php  echo $this->instances[$active_id]['opacity'] ?>" id="opacity" maxlength="<?php if($this->instances[$active_id]['window_unit'] == '%') echo '3'; else echo '5'; ?>" size="2" onchange="showValue(this.value)" />
							<span id="range"><?php  echo $this->instances[$active_id]['opacity'] ?></span>
							<span class="description hidden"><?php _e('The background opacity.<br />  Any value between 0 (transparent) and 100 (opaque)', 'tab-slide-pro') ?></span>
						</p>
					</td>
				</tr>	
				<?php echo apply_filters('tab_slide_settings_general_before_tab_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('TAB Settings', 'tab-slide-pro') ?></strong></th>
					<td>
						<p>
							<label for="tab_top">
								<?php _e('Position from top:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input( 'tab_top', '', 3,2 , $active_id, 'int'); ?>%
							<span class="description hidden"><?php _e('Vertical tab position relative to slide content height.<br /> Use any value between 0 (top of slide) and 100 (bottom of slide)', 'tab-slide-pro') ?></span>
						</p>
						<p class="peripheral">
							<label for="tab_height">
								<?php _e('Vertical TAB Size:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_height', '', '', 3,$active_id, 'int'); ?>px
						</p>
						<p class="peripheral">
							<label for="tab_width">
								<?php _e('Horizontal TAB Size:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_width', '', '', 3, $active_id, 'int'); ?>px	
						</p>
					</td>
				</tr>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('Font Settings', 'tab-slide-pro') ?></strong></th>
					<td>
						<p>
							<label for="font_family">
								<?php _e('Font:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'font_family', '', '', 30, $active_id ); ?>
						</p>
						<p>
							<label for="font_size">
								<?php _e('Font Size:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'font_size', '', '', 5, $active_id ); ?>
						</p>
						<p>
							<label for="font_color">
								<?php _e('Font Color:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'font_color', '', '', 5, $active_id ); ?>
							<div id="fontcolorpicker"></div>
						</p>
					</td>
					</tr>
				<?php echo apply_filters('tab_slide_settings_general_before_tab_slide_style_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('Tab Slide Style', 'tab-slide-pro') ?></strong></th>
					<td>		
						<p>
							<label for="cssonly">
								<?php _e('CSS Only Mode:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_radio ( 'cssonly', 'cssonly', 1, $active_id ); ?><?php _e('Yes', 'tab-slide-pro') ?>
							<?php $this->get_radio ( 'cssonly', 'integratedcss', 0, $active_id ); ?><?php _e('No', 'tab-slide-pro') ?>
							<div id="edit_css" class="css_only">
								<textarea name="new_opt[<?php echo $active_id ?>][css]" rows="10" cols="60" class="" id="edit_css_text"><?php echo $this->instances[$active_id]['css'] ?> </textarea>
							</div>
							<span class="description hidden"><?php _e('You can switch to css only mode and use cssonly.css to set up your tab slide.', 'tab-slide-pro') ?></span>
							<span class="description hidden"><?php _e('Note: If in CSS only mode, make sure you fill out the remaining settings that you will be using in your css as they are necessary for calculations and such', 'tab-slide-pro') ?></span>
						</p>
					</td>
				</tr>
				<?php echo apply_filters('tab_slide_settings_general_afte_tab_slide_style_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				</table>
			</div>
			<div id="advanced">
				<table class="form-table">
				<?php echo apply_filters('tab_slide_settings_advanced_before_display_settings_section', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('Display Settings', 'tab-slide-pro') ?></strong></th>
					<td>	
						<p>
							<label for="devices">
								<?php _e('Devices:', 'tab-slide-pro') ?>
									<select name="new_opt[<?php echo $active_id; ?>][device]"  id='device'>
										<option value="all" <?php if ($this->instances[$active_id]['device'] == 'all') echo ' selected' ?>><?php _e('Show on all devices', 'tab-slide-pro') ?></option>
										<option value="mobile" <?php if ($this->instances[$active_id]['device'] == 'mobile') echo ' selected' ?>><?php _e('Show on mobiles only', 'tab-slide-pro') ?></option>
										<option value="desktop" <?php if ($this->instances[$active_id]['device'] == 'desktop') echo ' selected' ?>><?php _e('Show on desktops only', 'tab-slide-pro') ?></option>
									</select>
							</label>
						</p>
						<?php echo apply_filters('tab_slide_settings_advanced_after_devices_option', '', $active_id, $this->instances[$active_id] ) ?>
						<p>
							<label for="credentials">
								<?php _e('Authentication:', 'tab-slide-pro') ?>
									<select name="new_opt[<?php echo $active_id; ?>][credentials]"  id='credentials'>
										<option value="all" <?php if ($this->instances[$active_id]['credentials'] == 'all') echo ' selected' ?>><?php _e('Show to all visitors', 'tab-slide-pro') ?></option>
										<option value="auth" <?php if ($this->instances[$active_id]['credentials'] == 'auth') echo ' selected' ?>><?php _e('Show only to logged in visitors', 'tab-slide-pro') ?></option>
										<option value="unauth" <?php if ($this->instances[$active_id]['credentials'] == 'unauth') echo ' selected' ?>><?php _e('Show only to logged out visitors', 'tab-slide-pro') ?></option>
									</select>
							</label>
						</p>
						<?php echo apply_filters('tab_slide_settings_advanced_after_credentials_option', '', $active_id, $this->instances[$active_id] ) ?>
						<p>
							<?php _e('Filter:', 'tab-slide-pro' ) ?>

							<select name="new_opt[<?php echo $active_id ?>][list_pick]" id="list_pick">
								<option value="all" <?php if ( $this->instances[$active_id]['list_pick'] === 'all' ) echo " selected='selected'"; ?>><?php _e( 'Include on all pages.', 'tab-slide-pro' ) ?></option>
								<option value="shortcode" <?php if ( $this->instances[$active_id]['list_pick'] === 'shortcode' ) echo " selected='selected'"; ?>><?php _e('Use the <b>[tabslide id='. $active_id .']</b> shortcode.', 'tab-slide-pro' ) ?></option>
								<option value="include" <?php if ( $this->instances[$active_id]['list_pick'] === 'include' ) echo " selected='selected'"; ?>><?php _e('Include only on page ID(s):', 'tab-slide-pro') ?></option>
								<option value="exclude" <?php if ( $this->instances[$active_id]['list_pick'] === 'exclude' ) echo " selected='selected'"; ?>><?php _e('Exclude from page ID(s):', 'tab-slide-pro') ?></option>
								<option value="disabled" <?php if ( $this->instances[$active_id]['list_pick'] === 'disabled' ) echo " selected='selected'"; ?>><?php _e('Disable this instance.', 'tab-slide-pro') ?></option>
							</select>
							<?php echo apply_filters('tab_slide_settings_advanced_after_filter_option', '', $active_id, $this->instances[$active_id] ) ?>
							<div class="padding list-pick-sub" id='list-pick-include'>
						            <?php  
							      $all_pages = get_all_page_ids();
							      $current_settings = $this->instances[$active_id]['include_list'];
							      $target_html = "<select multiple='multiple' id='include-ids' class='include-list' name='new_opt[". $active_id . "][include_list][]'>";
							      foreach ($all_pages as $post_ID => $value) {
								if(in_array($post_ID, $current_settings)) {
								  $target_attrib = ' selected="selected" ';
								} else {
								  $target_attrib = " ";
								}
							      $target_html .= "<option ". $target_attrib . " value='" . $post_ID . "' title='" . get_post_type($post_ID) . " page ID: " .  $post_ID . "'>" . get_the_title($post_ID) . "</option>";
							      }
							      $target_html .= "</select>";
							      echo $target_html;
							    ?>
							</div>
							<div class="padding list-pick-sub" id='list-pick-exclude'>
						            <?php
							      $current_settings = $this->instances[$active_id]['exclude_list'];
							      $target_html = "<select multiple='multiple' id='exclude-ids' class='exclude-list' name='new_opt[". $active_id . "][exclude_list][]'>";
							      foreach ($all_pages as $post_ID => $value) {
								if(in_array($post_ID, $current_settings)) {
								  $target_attrib = ' selected="selected" ';
								} else {
								  $target_attrib = " ";
								}
							      $target_html .= "<option ". $target_attrib . " value='" . $post_ID . "' title='" . get_post_type($post_ID) . " page ID: " .  $post_ID . "'>" . get_the_title($post_ID) . "</option>";
							      }
							      $target_html .= "</select>";
							      echo $target_html;
							    ?>
							</div>
							<div class="padding list-pick-sub" id='list-pick-shortcode'>
								<?php _e('<b>[tabslide id='. $active_id .']</b>', 'tab-slide-pro' ) ?>
							</div>
							<label for="disable_pages">
								<?php _e('Disable pages:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'disabled_pages', '', '', '', $active_id ); ?>	
							<span class="description hidden"><?php _e('example: template.php', 'tab-slide-pro') ?></span>	
						</p>
						<?php echo apply_filters('tab_slide_settings_advanced_after_disable_pages_option', '', $active_id, $this->instances[$active_id] ) ?>
						<p>
							<label for="animation_speed">
								<?php _e('Opening Speed:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'animation_speed', '', 6, 5, $active_id, 'float' ); ?><?php _e('seconds', 'tab-slide-pro') ?>
							<span class="description hidden"><?php _e('Set how long it takes for the tab to open.', 'tab-slide-pro') ?>
						</p>
						<p>
							<label for="animation_closing_speed">
								<?php _e('Closing Speed:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'animation_closing_speed', '', 6, 5, $active_id, 'float' ); ?><?php _e('seconds', 'tab-slide-pro') ?>
							<span class="description hidden"><?php _e('Set how long it takes for the tab to close.', 'tab-slide-pro') ?>
						</p>
						<?php echo apply_filters('tab_slide_settings_advanced_after_animation_speed_option', '', $active_id, $this->instances[$active_id] ) ?>
					</td>
				</tr>				

				<?php echo apply_filters('tab_slide_settings_before_cookie_settings', '', $active_id, $this->instances[$active_id] ) ?>
				<?php $cookie_settings = $this->instances[$active_id]['cookie_settings']; ?>
				<tr valign='top'>
          <th scope='row'><strong><?php _e( 'Cookie Settings', 'tab-slide' ); ?></strong></th>
          <td>
              <p>
		            <label for="cookie_enable">
			            <?php _e( 'Enable Cookie:', 'tab-slide' ) ?>
		            </label>
		            <input type="hidden" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_enabled]" value='0' />
			          <input type="checkbox" id="cookie_enabled" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_enabled]" value=1 <?php checked( $cookie_settings['cookie_enabled'] ); ?>/>
              </p>
			        <span class="description hidden"><?php _e( 'Control wheter or not to use the cookie functionality.', 'tab-slide' ) ?></span>
			        <div id="cookie_settings_wrap">
	              <p>
		              <label for="cookie_expires">
			              <?php _e( 'Cookie Expiry Time:', 'tab-slide' ) ?>
		              </label>
	                <input id="cookie_expires" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_expires]" value="<?php echo $cookie_settings['cookie_expires'] ?>" />
	              </p>
	              <span class="description hidden"><?php _e( 'Set the cookie expiry. You can use relative times to the current time, such as: +30 seconds, +1 minute 35 seconds, +2 weeks, +1 year, etc - or specific times such as:  10 September 2015, next Monday, etc', 'tab-slide' ) ?></span>
	              <p>
		              <label for="cookie_count_enabled">
			              <?php _e( 'Enable Cookie Count:', 'tab-slide' ) ?>
		              </label>
		              <input type="hidden" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_count_enabled]" value='0' />
			            <input id="cookie_count_enabled" type="checkbox" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_count_enabled]" value=1 <?php checked( $cookie_settings['cookie_count_enabled'] ); ?>/>
	              </p>
	              <span class="description hidden"><?php _e( 'Enable hiding tab-slide after a specific amount of views.', 'tab-slide' ) ?></span>
	              <p id="cookie_count_wrap">
		              <label for="cookie_count">
			              <?php _e( 'Cookie Count:', 'tab-slide' ) ?>
		              </label>
	                <input id="cookie_count" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_count]" value="<?php echo $cookie_settings['cookie_count'] ?>" />
	              <span class="description hidden"><?php _e( 'Do not show tab-slide after a specific amount of views.', 'tab-slide' ) ?></span>
	              </p>
	              <p>
		              <label for="cookie_render_html">
			              <?php _e( 'Always Render:', 'tab-slide' ) ?>
		              </label>
		              <input type="hidden" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_render_html]" value='0' />
			            <input id="cookie_render_html" type="checkbox" name="new_opt[<?php echo $active_id ?>][cookie_settings][cookie_render_html]" value=1 <?php checked( $cookie_settings['cookie_render_html'] ); ?>/>
	              </p>
	            </div>
          </td>
        </tr>
				<?php echo apply_filters('tab_slide_settings_before_theme_settings', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('Theme Integration Hook', 'tab-slide-pro') ?></strong></th>
					<td>
						<p>
							<select name="new_opt[<?php echo $active_id; ?>][hook]" id="hook">
								<option value='the_content' <?php if ( isset( $this->instances[$active_id]['hook']) && $this->instances[$active_id]['hook'] === 'the_content' ) echo " selected='selected'"; ?>>the_content (Default)</option>
								<option value='the_excerpt' <?php if ( isset($this->instances[$active_id]['hook']) && $this->instances[$active_id]['hook'] === 'the_excerpt' ) echo " selected='selected'"; ?>>the_excerpt</option>
								<option value='wp_footer' <?php if ( isset($this->instances[$active_id]['hook']) && $this->instances[$active_id]['hook'] === 'wp_footer' ) echo " selected='selected'"; ?>>wp_footer</option>
								<option value='wp_head' <?php if ( isset($this->instances[$active_id]['hook']) && $this->instances[$active_id]['hook'] === 'wp_head' ) echo " selected='selected'"; ?>>wp_head (Use as last resort only)</option>
								<option value='custom_filter' <?php if (  isset($this->instances[$active_id]['hook']) && $this->instances[$active_id]['hook'] === 'custom_filter' ) echo " selected='selected'"; ?>><?php _e('Custom Filter', 'tab-slide-pro') ?></strong></option>
							</select>
						</p>
						<span class="description hidden"><?php _e('Choose which hook is used to insert the tab slide content in your template. Consult with your theme developer to figure out what hook would be most appropriate to use for the page that you are targeting.', 'tab-slide-pro') ?>
						</span>
						<p class="hook_custom">
							<label for="hook_custom" class="hook_custom">
									<?php _e('Custom Filter Hook:', 'tab-slide-pro') ?>
							</label>
								<?php $this->get_input ( 'hook_custom', '', '', '', $active_id ); ?>
						</p>
						<p class="hook_custom">
							<span class="hook_custom description hidden"><?php _e('Add the filter hook to your template like so:', 'tab-slide-pro') ?>
							</span>
							<span class="hook_custom description hidden">
								<?php echo "echo apply_filters('{$this->instances[$active_id]['hook_custom']}', '');" ?>
							</span>
						</p>
					</td>
				</tr>
				<?php echo apply_filters('tab_slide_settings_before_tab_settings', '', $active_id, $this->instances[$active_id] ) ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e('TAB Settings', 'tab-slide-pro') ?></strong></th>
					<td>
						<p>
							<select name="new_opt[<?php echo $active_id; ?>][tab_type]" id="tab-type">
								<option value='text' <?php if ( $this->instances[$active_id]['tab_type'] === 'text' ) echo " selected='selected'"; ?>><?php _e('Tab Text', 'tab-slide-pro') ?></option>
								<option value='image' <?php if ( $this->instances[$active_id]['tab_type'] === 'image' ) echo " selected='selected'"; ?>><?php _e('Tab Image', 'tab-slide-pro') ?></option>
								<option value='scroll' <?php if ( $this->instances[$active_id]['tab_type'] === 'scroll' ) echo " selected='selected'"; ?>><?php _e( sprintf('Scroll trigger', $active_id), 'tab-slide-pro'); ?></option>
								<option value='custom' <?php if ( $this->instances[$active_id]['tab_type'] === 'custom' ) echo " selected='selected'"; ?>><?php _e( sprintf('Custom element trigger', $active_id), 'tab-slide-pro'); ?></option>
							</select>
							<p class="tab_image_settings tab-type-options">
								<label for="tab_image">
									<?php _e('Image Path:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_input ( 'tab_image', '', '', '', $active_id ); ?>
							</p>
							<p class="tab_custom_settings tab-type-options">
								<label for="tab_element">
									<?php _e('Target ID or Class:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_input ( 'tab_element', '', '', '', $active_id ); ?>
							</p>

						<div class="tab_text_settings tab-type-options" id="tab-text-inputs">
								<label for="tab_title_close">
									<?php _e('Closed View:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_input ( 'tab_title_close', '', '', 5, $active_id ); ?>	| 	
								<label for="tab_title_open">
									<?php _e('Opened View:', 'tab-slide-pro') ?>
								</label>
								<?php $this->get_input ( 'tab_title_open', '', '', 5, $active_id ); ?>
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="tab_margin_close">
								<?php _e('CLOSE Text Offset:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_margin_close', '', '', 3, $active_id ); ?>px | 

							<label for="tab_margin_open">
								<?php _e('OPEN Text Offset:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_margin_open', '', '', 3, $active_id ); ?>px
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="tab_color">
								<?php _e('Color:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_color', '', '', 8, $active_id ); ?>
							<span class="description hidden"><?php _e('Set the color of the tab as well as ALL the borders.', 'tab-slide-pro') ?></span>
							<div id="tabcolorpicker"></div>
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="font_size">
								<?php _e('Tab Font Size:', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'tab_font_size', '', '', 5, $active_id ); ?>
						</div>
						
						<div class="peripheral tab_scroll_settings tab-type-options">
							<label for="scroll_percentage_start">
								<?php _e('Keep tab slide open between ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'scroll_percentage_start', '', '', 5, $active_id ); ?>%
							<label for="scroll_percentage_end">
								<?php _e(' and ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'scroll_percentage_end', '', '', 5, $active_id ); ?>% <?php _e(' scroll height.', 'tab-slide-pro') ?>
						</div>
					</td>
				</tr>
				<?php echo apply_filters('tab_slide_settings_after_tab_settings', '', $active_id, $this->instances[$active_id] ) ?>							
				</table>
			</div>
			<?php
		}
	}
} 
