{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">Viewing: "{$d_name}" -- Version: {$v_name} -- Author: {$u_name} </div>
	<div class="box_content">
			<a style="font-weight:bold" href="editor.php">Start working off this version.</a>
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
	<ul class="tabs primary" id="othersversions_selected" style="display:block;">
  <li class="active"><span onclick="DisplayOthers()"><a class="active">Everyone's Versions</span></a></li>
	</ul>
	</div><!-- box_title-->

 	<div class="box_content" id="otherversionspanel" style="display:block;">
		<table>
			{section name=i loop=$others}
	<tr><td><div style="float: left; padding-right:4px;"><img src="{$others[i][0]}" /> </div><b>{$others[i][1]}</b><br />{$others[i][2]}</td></tr>
			{/section}
		</table>
	</div>
	
	<script type="text/javascript">
	{literal}
	//<![CDATA[
		$(document).ready(function(){
			$("#editor1").ckeditor(hideLoader("loader"));
		});

		CKEDITOR.replace( 'editor1', {toolbar : [ ] });
		var oEditor = CKEDITOR.instances['editor1'];
		oEditor.EditorDocument.body.disabled=true ;
	//]]>
	{/literal}
	</script>

{include file="footer.tpl"}
