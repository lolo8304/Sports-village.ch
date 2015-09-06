<?php
/**
* Search Form
*/

// We don't use HTML5 input type=search due to Safari webkit restrictions on styling the input
// See: http://css-tricks.com/webkit-html5-search-inputs/
?>
<form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
    	<input type="text" name="s" id="s" value="<?php echo (isset($_GET['s']) ? $_GET['s'] : ''); ?>" placeholder="<?php _e('Search Terms', 'slipstream'); ?>" />
        <input type="submit" value="<?php _e('Search', 'slipstream'); ?>" />
    </div>
</form>