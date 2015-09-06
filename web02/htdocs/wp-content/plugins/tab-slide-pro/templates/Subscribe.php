<?php do_action('tab_slide_subscribe_template'); ?>
<div id="login" align="center">
<form name="registerform" id="registerform" action="<?php echo get_site_url(); ?>/wp-login.php?action=register" method="post">
	<p>
		<label for="user_login">Username<br />
		<input type="text" name="user_login" id="user_login" class="input" value="" size="25" tabindex="10" /></label>
	</p>
	<p>
		<label for="user_email">E-mail<br />
		<input type="email" name="user_email" id="user_email" class="input" value="" size="25" tabindex="20" /></label>
	</p>
	<p id="reg_passmail">A password will be e-mailed to you.</p>
	<span class="clear" />
	<input type="hidden" name="redirect_to" value="" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Register" tabindex="100" /></p>
</form>
<script type="text/javascript">
function wp_attempt_focus() {
setTimeout( function(){ try {
d = document.getElementById('user_login');
d.focus();
d.select();
} catch(e){}
}, 200);
}
if(typeof wpOnload=='function')wpOnload();
</script>
		</div>
<div class="clear"></div>
