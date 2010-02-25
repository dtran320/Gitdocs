<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>GitDocs - 	note the world</title>
 <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
 <link rel="stylesheet" type="text/css" href="css/main.css"/> 
 <link rel="stylesheet" type="text/css" href="css/index.css"/> 
 <link rel="stylesheet" type="text/css" href="css/compare.css"/> 
 <link rel="stylesheet" type="text/css" href="css/import.css"/>
 <link rel="stylesheet" type="text/css" href="css/tabs.css"/>
 <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css"/>

 <link rel="stylesheet" type="text/css" href="lib/Jcrop/css/jquery.Jcrop.css" />
 <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />


 <script type="text/javascript" src="js/lib/jquery-1.4.js"></script>
 <script type="text/javascript" src="js/gitdocs.js"></script>
 <script type="text/javascript" src="js/compare.js"></script>
 <script type="text/javascript" src="js/browse.js"></script>
 <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
 <script type="text/javascript" src="./ckeditor/adapters/jquery.js"></script>
 <script type="text/javascript" src="js/editor.js"></script>
 <script type="text/javascript" src="js/upload.js"></script>

 <script type="text/javascript" src="lib/Jcrop/js/jquery.Jcrop.js"></script>
 <script type="text/javascript" src="js/lib/jquery-ui-1.7.2.custom.min.js"></script>
 <script src="js/lib/jquery.form.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/additional-methods.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/jquery.metadata.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/jquery.placeholder.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/pretty-dates.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/lib/jquery.autocomplete.js" type="text/javascript" charset="utf-8"></script>


 </head>
 <body>
 <div class="wide_header">
	<div style="float:left;">
	<div class="wide_gitdocs"><a href="index.php">GitDocs</a> <span class="page_title">note the world</span></div>
	</div>
	{if isset($logged_in_user) }
		<div class="float_right" style="margin:20px 10px 0px 0px;">
		<div class="float_left logged_in_user"><a href="new_note.php">Add Notes</a></strong> | <a href="browse.php">Browse Classes</a> | <a href="change_avatar.php">Account</a> | Logged in as {$logged_in_user.displayName} | <a href="index.php?action=logout">Logout</a></div>

<!-->		<div class="float_right"> 
			<form id="form_search" class="reg_form" action="search.php" method="get">
			<input type="text" name="query" value="Find a document" />
			<input type="submit" value="Search" />
			</form>
		</div>-->
		</div>
	{else}
		<div class="float_right" style="margin:20px 10px 0px 0px;">
			<div class="login_error" id="login_error"></div>
			<form id="login" class="reg_form" action="actions/signin.php" method="post">
				<input type="text" id="login_username" name="username" value="" placeholder="Email/Username"/>
				<input type="password" id="login_password" name="password" value="" placeholder="Password"/>
				<input type="submit" name="submit" value="Login" />
			</form>
		</div>
		 <script type="text/javascript">
			{literal}
			//<![CDATA[
				 $(document).ready(function() {
					$("#login_username").placeholder();
					$("#login_password").placeholder();
					
					$('#login').ajaxForm({
						success:      	postSignIn
					});
				});
				
				function postSignIn(data) {
					if(data=="1") {
				    	window.location = "index.php";
					}
					else {
						$("#login_error").html("Incorrect email/password combination.");
						$("#login_error").addClass("error");
					}
				}
				
			//]]>
			{/literal}
		</script>
	{/if}
 </div><!-- end wide_header -->

<a id="feedback" href="http://gitdocs-bugs.doesntexist.com">&nbsp;</a>
