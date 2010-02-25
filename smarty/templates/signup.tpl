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
					<td><label for="username">Email:</label></td>
					<td><input type="text" id="signup_username" name="username" value="" placeholder="Your email address"/></td>
				</tr>
				<tr>
					<td><label for="first_name">First Name:</label></td>
					<td><input type="text" id="signup_first_name" name="first_name" value="" placeholder="Your first name"/></td>
				</tr>
				<tr>
					<td><label for="last_name">Last Name:</label></td>
					<td><input type="text" id="signup_last_name" name="last_name" value="" placeholder="Your last name"/></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="signup_password" name="password" value="" placeholder="password"/></td>
				</tr>
				<tr>
					<td><label for="password_confirm">Confirm Password:</label></td>
					<td><input type="password" id="signup_confirm_password" name="password_confirm" value="" placeholder="password"/></td>
				</tr>
				<tr><td></td><td><input type="submit" name="submit" class="green_button" value="Sign Up" onclick="signUpUser(event);"/></td></tr>
			</table>

		</form>
	</div>
</div><!-- end box_full -->
<div style="margin-left: 20px;">
<div class="headline_blue">Explore Gitdocs</div>
	<div class="left_side60">
		<div class="box">
				<div class="box_title">Recently saved documents</div>
			       	<div class="box_content">
						<table class="document_list" id="recent_global">
							{section name=i loop=$recent_global_docs}
								<tr onclick="window.location='{$recent_global_docs[i].link};'">
									<td><img src="{$recent_global_docs[i].iconPtr}"></td>
									<td>{$recent_global_docs[i].displayName} saved a version of</td>
									<td><p>{$recent_global_docs[i].dName} {$recent_global_docs[i].vName}</p></td><td><p class="time small_text" id="{$recent_global_docs[i].timestamp}">{$recent_global_docs[i].timestamp}</p></a></td></tr>
							{/section}
								</table>
						</div><!-- end box content -->
			</div><!-- end box -->
</div><!-- end left -->
<div class="right_side35">
<div class="box">
	 <div class="box_title">Recent <a href="http://twitter.com/gitdocs">@gitdocs</a> updates</div>
       <div class="box_content">
			<table>
			{section name=i loop=$twitter_updates}
			<tr><td class="time" id="{$twitter_updates[i].update_time}">{$twitter_updates[i].update_time}</td></tr>
			<tr><td>{$twitter_updates[i].update_text}</td></tr>
			<tr><td>&nbsp;</td></tr>
			{/section}
			</table>
		</div>
</div>
</div>

</div>
<script type="text/javascript">
	{literal}
	//<![CDATA[
	$(document).ready(function() {
		$(".time").prettyDate();
		setInterval(function(){ $(".time").prettyDate(); }, 10000);
		$("#signup_username").placeholder();
		$("#signup_first_name").placeholder();
		$("#signup_last_name").placeholder();
		$("#signup_confirm_password").placeholder();
		$("#signup_password").placeholder();
		});
		
	//]]>
	{/literal}
</script>

{include file="footer.tpl"}
