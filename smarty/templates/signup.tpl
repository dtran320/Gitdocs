{include file="header.tpl"}

<div class="box_full">
	<div class="left_side60" style="margin-left: 20px;">
		{if isset($error) }
			<div class="error">{$error}</div>
		{/if}

		<div class="headline">Share notes with your classmates</div>
		{$gitdocs_description}
	</div>
	<div class="right_side30" style="margin-left: 20px;">
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
	<div class="left_side45" style="margin-left: 20px;">
<div class="box">
	<div class="headline_blue">Recently saved documents</div>               
	<div class="box_content">
            <table class="document_list" id="recent_global">
              {section name=i loop=$recent_global_docs}
               <tr onclick="window.location='{$recent_global_docs[i].link}'">
                  <td><img src="{$recent_global_docs[i].iconPtr}"></td>
                  <td><p><span class="username">{$recent_global_docs[i].displayName}</span></td><td>{$recent_global_docs[i].course}</td><td><span class="lecture_title bold">{$recent_global_docs[i].dName}</span> <span class="v_name">{$recent_global_docs[i].vName}</span></p></td><td><p class="time small_text" id="{$recent_global_docs[i].timestamp}">{$recent_global_docs[i].timestamp}</p></a></td></tr>
              {/section}
                </table>
            </div><!-- end box content -->
      </div><!-- end box -->

 </div> <!-- end left_side -->

<div class="right_side45">
<div class="box" style="margin-left: 20px;">
	<div class="headline_blue">Explore Gitdocs</div>	
	<div class="box_title">Choose a class to see its notes</div>
  <div class="box_content">
		<table id="main_class_list" style="float: left;">
			<tr>
			{section name=i loop=$all_classes}	
				{if $all_classes[i]} <td onclick="window.location='browse.php?class={$all_classes[i]}'"><p>{$all_classes[i]}</p></td>{/if}
				{if ($smarty.section.i.iteration %5 == 4)} </tr><tr>{/if}
			{/section}
			</tr>
		</table>
		<table id="notes_for_class">
		</table>
		<div style="float: right;width: 280px;" id="avatars"></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div>

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
			if(data!="0") {
			window.location=data;
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
