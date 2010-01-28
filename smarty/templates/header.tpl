 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>GitDocs - Where the world writes</title>
 <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
 <!-- // vrindavan flower from kuler.adobe.com -->
 <link rel="stylesheet" type="text/css" href="css/main.css"/> 
 <link rel="stylesheet" type="text/css" href="css/index.css"/> 
 <link rel="stylesheet" type="text/css" href="css/compare.css"/> 
 <link rel="stylesheet" type="text/css" href="css/import.css"/>
 <link rel="stylesheet" type="text/css" href="css/tabs.css"/>

 <script type="text/javascript" src="js/jquery-1.4.js"></script>
 <script type="text/javascript" src="js/gitdocs.js"></script>
 <script type="text/javascript" src="js/compare.js"></script>
 <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
 <script type="text/javascript" src="./ckeditor/adapters/jquery.js"></script>
 <script type="text/javascript" src="js/editor.js"></script>
 </head>
 <body>
 <div class="wide_header">
	<div style="float:left;">
	<div class="wide_gitdocs"><a href="index.php">GitDocs</a> <span class="page_title">Where the world writes</span></div>
	</div>
	{if isset($logged_in_user) }
		<div class="float_right" style="margin:20px 10px 0px 0px;">
		<div class="float_left logged_in_user">{$logged_in_user.displayName}</div>
		<div class="float_right"> 
			<form id="form_search" class="big_form" action="search.php" method="get">
			<input type="text" name="query" value="Find a document" />
			<input type="submit" value="Search" />
			</form>
		</div>
		</div>
	{/if}
 </div><!-- end wide_header -->
