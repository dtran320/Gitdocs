{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">Editing: "{$d_name}" -- Version: {$v_name} -- Author: you </div>
	<div class="box_content">
			<div id="loader"><img src="images/ajax-loader.gif"></div>
			<div>
			<form method="post">
				<textarea name="editor1" id="editor1">
				{$v_text}
				</textarea>
			</form>
			</div>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	<ul class = "tabs primary" id ="myversions_selected">
		<li class = "active" id="myversions_tab"><span onclick="DisplayMine()"><a class="active">My Versions</a></span></li>
		<li><span onclick="DisplayOthers()">Others' Versions</span></li>
	</ul>
	<ul class="tabs primary" id="othersversions_selected" style="display:none;">
	 <li id="myversions_tab"><span onclick="DisplayMine()">My Versions</span></li>
	 <li class="active"><span onclick="DisplayOthers()"><a class="active">Others' Versions</span></a></li>
	</ul>
	</div><!-- box_title-->
  <div class="box_content" id="myversionspanel" style="display:block;">
  	<table>
			{section name=i loop=$history}	
				<tr><td><div style="float: {$history[i][0]}; padding-right:6px;"><img src="{$history[i][1]}" /> </div>{$history[i][2]}</td></tr>
			{/section}
		</table> 
	</div>
	
	<div class="box_content" id="otherversionspanel" style="display:none;">
		<table>
			{section name=i loop=$others}	
			<tr><td><div style="float: left; padding-right:6px;"><img src="{$others[i][0]}" /> </div>{$others[i][1]}</td></tr>
			{/section}
	</div>
	
	<script type="text/javascript">
	{literal}
	//<![CDATA[
		$(document).ready(function(){
			$("#editor1").ckeditor(hideLoader("loader"));
		});
	
		CKEDITOR.replace( 'editor1',
		{
			toolbar :
			[
				// for full toolbar: look at http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
				['Cut','Copy','Paste', '-', 'Undo','Redo'],
				['Bold','Italic','Underline'],
				['Font','FontSize'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Maximize']
			]
		});

	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
