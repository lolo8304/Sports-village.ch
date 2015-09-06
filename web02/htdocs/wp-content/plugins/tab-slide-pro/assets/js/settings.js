var allOpt;
allOpt = j_options;
/*
 * Save the tab slide pro api key
 * @params key
 */
function save_api_key(key) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'key':key,
			'postNonce': PostAjax.postNonce,
			'fn':'savekey'
		},
		dataType: 'html',
		success:function(data){
			console.log(data);
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Duplicates an instance copying all the settings and creating a unique id
 * @params id
 */
function clone_this_instance(id) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'instance_id':id,
			'postNonce': PostAjax.postNonce,
			'fn':'clone'
		},
		dataType: 'html',
		success:function(data){
			location.reload();
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Delete an instance and all its settings
 * @params id
 */
function delete_this_instance(id) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'instance_id':id,
			'postNonce': PostAjax.postNonce,
			'fn':'delete'
		},
		dataType: 'html',
		success:function(data){
			location.reload();
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Enable an instance
 * @params id
 */
function enable_this_instance(id) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'instance_id':id,
			'postNonce': PostAjax.postNonce,
			'fn':'enable'
		},
		dataType: 'html',
		success:function(data){
			location.reload();
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Disable an instance
 * @params id
 */
function disable_this_instance(id) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'instance_id':id,
			'postNonce': PostAjax.postNonce,
			'fn':'disable'
		},
		dataType: 'html',
		success:function(data){
			location.reload();
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Regenerate the css file, by populating the css file with the instance settings in css context
 * @params id
 */
function refresh_instance_css(id) {
    jQuery.ajax({
		url: PostAjax.ajaxurl,
		data:{
			'action': 'settings_ajax_handler',
			'instance_id':id,
			'postNonce': PostAjax.postNonce,
			'fn':'refresh'
		},
		dataType: 'html',
		success:function(data){
			jQuery('#edit_css_text').val(data);
		},
		error: function(errorThrown){
			//alert('error');
			console.log(errorThrown);
		}
    });
}
/*
 * Settings page front end
 */
jQuery(document).ready(function() {
	var myOptions, val, oldSelection, i;
  jQuery('.nav-tab-wrapper').on('change', function() {
    window.location = '?page=tab-slide-pro&tab=' + this.value;
  });
  jQuery('.save-settings').click(function() {
    jQuery('input[name=info_update]').trigger('click');
  });
	jQuery("#save-api-key").click(function () {
		save_api_key(jQuery('#api-key').val());
	});
	//var activeId = document.activeId;
	opt = allOpt[window.activeId]; 
	if ( opt.show_on_load == 1 ) {
		jQuery('#autoopen_timer').addClass('hidden');
		jQuery('#autohide_timer').addClass('shown');
	} else {
		jQuery('#autoopen_timer').addClass('shown');
		jQuery('#autohide_timer').addClass('hidden');
	}
	jQuery("input:checkbox[class*=show_on_load]").click(function () {
		jQuery('#autoopen_timer').toggleClass('hidden shown');
		jQuery('#autohide_timer').toggleClass('hidden shown');
		return;
	});
	function testValue(newOption) {
		for (i = 0; i < myOptions.length; i = i + 1) {
			if (newOption === myOptions[i]) {
				jQuery("#" + newOption).show();
				if (newOption !== "Custom") {
					//set the new template window url
					jQuery("#window_url").val("/templates/" + newOption + ".php");
					if (newOption !== "Widget" || newOption !== "iFrame" || newOption !== "Video" || newOption !== "Picture") {
					}
				}
			} else {
				jQuery("#" + myOptions[i]).hide();
			}
		}
	}
	oldSelection = opt.template_pick;
	jQuery("#template_select").bind(jQuery.browser.msie ? 'propertychange' : 'change', function (e) {
		e.preventDefault();
		var selectValue, selectOption;
		selectValue = document.getElementById('template_select').value;
		selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
		jQuery("#template_pick").val(selectOption);
		jQuery("#template_select").click(testValue(selectOption));
	});
	jQuery("#template_select").change(function () {
		var selectValue, selectOption;
		selectValue = jQuery('#template_select').val();
		selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
		jQuery("#template_pick").val(selectOption);
		jQuery("#template_select").change(testValue(selectOption));
	});
	myOptions = [];
	jQuery("#template_select").find('option').each(function () {
		val = jQuery(this).text();
		myOptions.push(val);
	});
	testValue(oldSelection);
	jQuery("select[name=template_select] option[value=" + oldSelection + "]").attr("selected", true);
	 
	if( jQuery(".no_borders").attr('checked')){
			jQuery('.border_size').hide();
	} else {
			jQuery('.border_size').show();
	}
	jQuery(".yes_borders").click(function(){
		jQuery('.border_size').show();
	});
	jQuery(".no_borders").click(function(){
		jQuery('.border_size').val("0");
		jQuery('.border_size').hide();
	});
	jQuery('#bgcolorpicker').hide();
	jQuery("#background").click(function(){jQuery('#bgcolorpicker').slideToggle()});
	jQuery('#tabcolorpicker').hide();
	jQuery("#tab_color").click(function(){console.log('tab color');jQuery('#tabcolorpicker').slideToggle()});
	jQuery('#fontcolorpicker').hide();
	jQuery("#font_color").click(function(){jQuery('#fontcolorpicker').slideToggle()});


	
	jQuery(".general").click(function(){
		jQuery('#advanced').hide()
		jQuery('#general').show();
		jQuery(".current").toggleClass('current');
		jQuery(".general").toggleClass('current');
	});
	jQuery(".advanced").click(function(){
		jQuery('#advanced').show()
		jQuery('#general').hide();
		jQuery(".current").toggleClass('current');
		jQuery(".advanced").toggleClass('current');
	});
	jQuery('.help-descriptions').click(function(){
		jQuery('.description').toggleClass('hidden shown');
	});
	jQuery('#overlay').click(function(){
		jQuery('#overlay').toggleClass('hidden shown');
		jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('#close_about').click(function(){
		jQuery('#overlay').toggleClass('hidden shown');
		jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('.about').click(function(){
			jQuery('#overlay').toggleClass('hidden shown');
			jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('#bgcolorpicker').farbtastic(function(color){
		jQuery('#background').val(color);
		jQuery('#background').css('background', color);
	});
	
	jQuery('#tabcolorpicker').farbtastic(function(color){
		jQuery('#tab_color').val(color);
		jQuery('#tab_color').css('background', color);
	});
	jQuery('#fontcolorpicker').farbtastic(function(color){
		jQuery('#font_color').val(color);
		jQuery('#font_color').css('background', color);
	});

	if( jQuery(".cssonly").attr('checked')){
		jQuery('.peripheral').hide();
		jQuery('.css_only').show();
	} else {
		jQuery('.peripheral').show();
		jQuery('.css_only').hide();
	}
	jQuery(".cssonly").click(function(){
		jQuery('.peripheral').hide()
		jQuery('.css_only').show();
		refresh_instance_css(jQuery('#current_id').val());
	});
	jQuery(".integratedcss").click(function(){
		jQuery('.peripheral').show()
		jQuery('.css_only').hide();
	});
	jQuery('.tab-type-options').hide();	
	if( jQuery(".cssonly").attr('checked') !=='checked'){
		jQuery('.tab_' + jQuery('#tab-type').val() + '_settings').show();
	} else {
		if(jQuery('#tab-type').val() === 'text') {
			jQuery('.tab-type-options').hide();
			jQuery('#tab-text-inputs').show();
		} else {
			jQuery('.tab-type-options').hide();
			jQuery('#tab-text-inputs').hide();
			if (jQuery('#tab-type').val() === 'custom') {
				jQuery('.tab_custom_settings').show();
			}
		}
	}

	jQuery('#tab-type').on('change', function() {
		if( jQuery(".cssonly").attr('checked') !=='checked'){
			jQuery('.tab-type-options').hide();
			jQuery('.tab_' + this.value + '_settings').show();
			if(this.value === 'text') {
				jQuery('#tab-text-inputs').show();
			}
		} else {
			if(this.value === 'text') {
				jQuery('.tab-type-options').hide();
				jQuery('#tab-text-inputs').show();
			} else {
				jQuery('.tab-type-options').hide();
				jQuery('#tab-text-inputs').hide();
				if (this.value === 'custom') {
					jQuery('.tab_custom_settings').show();
				}
			}
		}
	});

	if( jQuery('#hook').val() === 'custom_filter' ){
		jQuery('.hook_custom').show();
	} else {
		jQuery('.hook_custom').hide();
	}	
	jQuery('#hook').on('change', function() {
		if( jQuery(this).val() ==='custom_filter'){
			jQuery('.hook_custom').show();
		} else {
			jQuery('.hook_custom').hide();
		}
	});

	if( jQuery('#list_pick').val() !== 'all' || jQuery('#list_pick').val() !== 'disabled' ) {
		jQuery('#list-pick-' + this.value).show();
	}
	jQuery('#list_pick').on('change', function() {		
		jQuery('.list-pick-sub').hide();
		if( this.value !== 'all' || this.value !== 'disabled' ) {
			jQuery('#list-pick-' + this.value).show();
		}
	});
	// Make the select multiple box more user friendly using bsmSelect
	jQuery("#include-ids").bsmSelect({
		addItemTarget: 'bottom',
		animate: true,
		highlight: true,
		plugins: []
	});
	// Append previous titles to the new select multiple 
	jQuery('#include-ids > option').each(function() {
		var currentVal= this.value;
		var currentTitle = this.title;
		jQuery('#bsmSelectbsmContainer0 > option').each(function() {
		  if (currentVal == this.value) {
			var currentOption = jQuery('#bsmSelectbsmContainer0').find('option[value='+ this.value +']');
			currentOption.attr('title', currentTitle);
		  }
		});
	});;
	// Make the select multiple box more user friendly using bsmSelect
	jQuery("#exclude-ids").bsmSelect({
		addItemTarget: 'bottom',
		animate: true,
		highlight: true,
		plugins: []
	});
	// Append previous titles to the new select multiple 
	jQuery('#exclude-ids > option').each(function() {
		var currentVal= this.value;
		var currentTitle = this.title;
		jQuery('#bsmSelectbsmContainer1 > option').each(function() {
		  if (currentVal == this.value) {
			var currentOption = jQuery('#bsmSelectbsmContainer1').find('option[value='+ this.value +']');
			currentOption.attr('title', currentTitle);
		  }
		});
	});
  if ( jQuery("#cookie_enabled").prop('checked') ) {
	  jQuery("#cookie_settings_wrap").show();
  }
  jQuery("#cookie_enabled").on("click", function() {
    jQuery("#cookie_settings_wrap").toggle();
  });
  if ( jQuery("#cookie_count_enabled").prop('checked') ) {
	  jQuery("#cookie_count_wrap").show();
  }
  jQuery("#cookie_count_enabled").on("click", function() {
    jQuery("#cookie_count_wrap").toggle();
  });
  	jQuery('#pro_api_key').on('click', function() {
		jQuery("#api_key_input").slideDown();
	});
	jQuery('#save_api_key').on('click', function() {
		jQuery("#api_key").val(jQuery("#api_key_input>input").val());
		jQuery('input[type="submit"]').click();
	});
	jQuery(window).scroll(function() {
    var wintop = jQuery(window).scrollTop(), docheight = jQuery(document).height(), winheight = jQuery(window).height();
    var  scrollTriggerStart = parseInt(1, 10)/100;
    var  scrollTriggerEnd = parseInt(100, 10)/100;
      
      if ((wintop/(docheight-winheight)) >= scrollTriggerStart && scrollTriggerEnd >= (wintop/(docheight-winheight))) {
        jQuery('#header-wrapper').css({'background': 'none repeat scroll 0 0 #FFFFFF', 'box-shadow': '0 0 1px #000000'}); 
      } else {
        jQuery('#header-wrapper').css({'background-color': 'none', 'box-shadow': 'none'}); 
      }
      
  });
});
function showValue(newValue) {
	document.getElementById("range").innerHTML = newValue;
}
