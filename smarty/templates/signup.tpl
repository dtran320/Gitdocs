{include file="header.tpl"}

<div class="box_full">
	<div class="left_side45" style="margin-left: 20px;">
		{if isset($signin_error) }
			<div class="error">{$signin_error}</div>
		{/if}

		<div class="headline">Share notes with your classmates</div>
		<p>Why study for tests in isolation? Want to share notes but not sure how to do so effectively? 
		Gitdocs allows you to upload your class notes and manage sections of notes from your classmates,
		choosing only those contributions you feel will be helpful to your version of your notes.</p>
	</div>
	<div class="right_side45" style="margin-left: 20px;">
		<div class="headline">Sign up and start sharing:</div>
		<div class="signup_error" id="signup_error"></div>
		<form id="signup" class="big_form" action="actions/signup.php" method="post">
			<table>
				<tr>
					<td><label for="username">Username:</label></td>
					<td><input type="text" id="signup_username" name="username" value="" placeholder="Your login name"/></td>
				</tr>
				<tr>
					<td><label for="display_name">Display Name:</label></td>
					<td><input type="text" id="signup_display_name" name="display_name" value="" placeholder="Your display name"/></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="signup_password" name="password" value="" placeholder="password"/></td>
				</tr>
				<tr>
					<td><label for="password_confirm">Confirm Password:</label></td>
					<td><input type="password" id="signup_confirm_password" name="password_confirm" value="" placeholder="password"/></td>
				</tr>
				<tr><td></td><td><input type="submit" name="submit" value="Sign Up" onclick="signUpUser(event);"/></td></tr>
			</table>

		</form>
	</div>
</div><!-- end box_full -->
<div style="margin-left: 20px;">
<div class="headline_blue">Explore Gitdocs</div>
	<div class="left_side45">
<div class="box">
	<div class="box_title">Popular topics</div>
       	<div class="box_content">
		<div style="padding-bottom:20px;">
			<table>
			{section name=i loop=$pop_tops}
			<tr><td><span style="color:{cycle values="#1E1E1F, #67666A, #807F83, #CBC9CF"}">{$pop_tops[i]}</span></td></tr>
	<!-- el gray from kuler -->
			{/section}
			</table>
			</div>
		</div>
</div>
</div>
<div class="right_side45">
<div class="box">
	 <div class="box_title">Popular documents</div>
       <div class="box_content">
			<table>
			{section name=i loop=$pop_docs}
			<tr><td>{$pop_docs[i]}</td></tr>
			{/section}
			</table>
		</div>
</div>
</div>

</div>
<script type="text/javascript">
	{literal}
	//<![CDATA[
		$("#signup_username").placeholder();
		$("#signup_display_name").placeholder();
		$("#signup_confirm_password").placeholder();
		$("#signup_password").placeholder();
	//]]>
	{/literal}
</script>
{include file="footer.tpl"}
