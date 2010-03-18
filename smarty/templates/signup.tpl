{include file="header.tpl"}

<div class="box_full">
	<div class="left_side45" style="margin-left: 20px;">
		{if isset($error) }
			<div class="error">{$error}</div>
		{/if}

		<div class="headline">Share notes with your classmates</div>
		{$gitdocs_description}
	</div>
	<div class="right_side45" style="margin-left: 20px;">
		<div class="headline">Sign up and start sharing:</div>
		<div class="signup_error" id="signup_error"></div>
		<form id="signup" class="big_form" action="actions/signup.php" method="post">
			<table>
				<tr>
					<td><label for="username">Email:</label></td>
					<td><input type="text" id="signup_username" name="username" value=""/></td>
				</tr>
				<tr>
					<td><label for="first_name">First Name:</label></td>
					<td><input type="text" id="signup_first_name" name="first_name" value=""/></td>
				</tr>
				<tr>
					<td><label for="last_name">Last Name:</label></td>
					<td><input type="text" id="signup_last_name" name="last_name" value=""/></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="signup_password" name="password" value=""/></td>
				</tr>
				<tr>
					<td><label for="password_confirm">Confirm Password:</label></td>
					<td><input type="password" id="signup_confirm_password" name="password_confirm" value=""/></td>
				</tr>
				<tr><td></td><td><input type="submit" name="submit" class="green_button" value="Sign Up"/></td></tr>
			</table>

		</form>
	</div>
</div><!-- end box_full -->
<div class="headline_blue" style="margin-left: 20px;">Explore Gitdocs</div>	
<div class="box" style="margin-left: 20px;">
	<div class="box_title">Choose a class to see its notes</div>
  <div class="box_content">
		<table id="class_list" class="document_list" style="float: left; width:100px;">
			{section name=i loop=$all_classes}	
				<tr><td onclick="showNotesForClass('{$all_classes[i]}');"><p>{$all_classes[i]}</p></td></tr>
			{/section}
		</table>
		<table id="notes_for_class">
		</table>
		<div style="float: right;width: 280px;" id="avatars"></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end container -->
<script type="text/javascript">
	{literal}
	//<![CDATA[
	$(document).ready(function() {
		$(".time").prettyDate();
		setInterval(function(){ $(".time").prettyDate(); }, 10000);
		
		$('#signup').ajaxForm({
				 beforeSubmit: preSignUp,
				 success: postSignUp
		});

	});
		
		function preSignUp() {
			var username = $("#signup_username").val();
			var firstname = $("#signup_first_name").val();
			var lastname = $("#signup_last_name").val();
			var password = $("#signup_password").val();
			var password_c = $("#signup_confirm_password").val();
			
			var error = "";
			if(username == "") {
				error += "You must supply an email address/username.\n";
			}
			if(firstname == "") {
				error += "You must enter a first name.\n";
			}
			if(lastname == "") {
				error += "You must enter a last name.\n";
			}
			if(password == "" || password_c == "" || password != password_c) {
				error += "Passwords must match and not be blank.\n";
			}
			
			if (error != "") {
				alert (error);
				return false;
			}
			return true;
		}
		
		function postSignUp(data) {
			if(data=="1") {
			window.location="index.php";
			}
			else { //should eventually capture errors and tell them what's wrong
				$("#signup_error").html("Error with your signup. Please try again.");
				$("#signup_error").addClass("error");
			}
		}
		
	//]]>
	{/literal}
</script>

{include file="footer.tpl"}
