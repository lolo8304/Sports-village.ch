/**
* WordPress 3.5+ Media Library Uploader
*/
(function($){
	media = {
		// Process when a button with class .insert-media-url is clicked
		init: function() {
			// Insert
			$('#wpbody').on('click', '.insert-media-url', function(e) {
				e.preventDefault();
				
				// Get 'editor' (id to our input field)
				var editor = $(this).data('editor');
				if (!editor) return;

				// Open media manager
				var mediaManager = wp.media({
					frame:    'post',
					title:    'Choose Image',
					multiple: false
				});
				mediaManager.open();
				
				// When the insert button is clicked in the media manager:
				// - check we have chosen a valid image,
				// - insert it into the input id field
				mediaManager.on('insert', function(selection) {
					selection.map(function(attachment) {
						if (attachment.get('type') != 'image') {
							alert('Please choose a valid image.');
							return;
						}
						
						$('input#'+editor).val(attachment.get('id')).trigger('change');
						$('a.'+editor).next('a.delete').removeClass('hidden');
						if ($('span.'+editor).length > 0) {
							$('span.'+editor).html('<img src="'+attachment.get('url')+'" width="100%" />');
						}
					});
				});
			});
			
			// Delete
			$('a.delete').click(function(e) {
				// Check delete button corresponds to a media uploader
				var editor = $(this).data('editor');
				if (!editor) return;
				
				// Remove image + image value in hidden field
				$('input#'+editor).val('').trigger('change');
				if ($('span.'+editor).length > 0) {
					$('span.'+editor).html('');
				}
				
				// Hide delete button
				$(this).addClass('hidden');
			});
		}
	};

	// Start init process
	$(media.init);
}(jQuery));