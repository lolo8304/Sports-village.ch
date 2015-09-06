jQuery(document).ready(function($) {
    // Mobile Navigation
    $('#responsive-menu-button').sidr({
    	name: 'sidr-main',
    	source: '#navigation'
    }); 
});

/**
* Search Header
*/
(function($){
	searchHeader = {	
		/**
		* Listens for change events
		*/
		init: function() {
			// Get form, button and field
			var searchForm = $('#header form.searchform');
			var searchButton = $('input[type=submit]', $(searchForm));
			var searchField = $('input#s', $(searchForm));
			
			// Change layout based on window size
			$(searchField).addClass('horizontal').show();
			$(searchButton).addClass('horizontal');
			
			// This will fire when either the button is clicked or the enter key is pressed when
			// focused on the input field
			// By passing onto keypress(), we can detect whether there was a click, enter key or other key
			// pressed, and choose to show/hide the search box, submit it or do nothing accordingly.
			$(searchButton).click(function(e) {
				$(searchField).keypress();
				e.preventDefault();
			});	
			$(searchField).keypress(function(e) {
				if (e.which == 13) {
					// Enter key pressed - submit the form
					$(searchForm).submit();
				} else {
					if (typeof e.which === 'undefined') {
						searchHeader.toggle(searchButton, searchField, searchForm);	
					}
				}
			});
		},
		
		/**
		* Shows or hides the search field
		*/
		toggle: function(searchButton, searchField, searchForm) {
			if (parseInt($(searchField).css('marginRight')) == 0) {
				// Hide
				$(searchField).animate({
					marginRight: '-'+$(searchField).outerWidth()+'px'
				});
				$(searchForm).css('z-index', '1');
			} else {
				// Show
				$(searchForm).css('z-index', '100');
				$(searchField).animate({
					marginRight: 0
				});
			}
		}
	}	
	
	// Init
	$(searchHeader.init);	
})(jQuery);