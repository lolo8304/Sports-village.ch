<?php do_action('tab_slide_wplogin_template'); ?>
<div id="login" align="center">
<form name="loginform" id="loginform" action="<?php echo get_site_url(); ?>/wp-login.php" method="post">
	<p>
		<label for="user_login">Username<br />
		<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label for="user_pass">Password<br />

		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
	</p>
	<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100" />
		<input type="hidden" name="redirect_to" value="<?php echo get_site_url(); ?>/wp-admin/" />
		<input type="hidden" name="testcookie" value="1" />
	</p>

</form>

<p id="nav">
<a href="<?php echo get_site_url(); ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a>
</p>

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
