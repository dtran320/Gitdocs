{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">{$d_name} -- <span class="v_name">{$v_name}</span> -- <span class="u_name">{$u_name}</span> 
<a style="font-weight:bold; float: right;" href="editor.php">Start working off this version.</a>

</div>
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
	<ul class="tabs primary" id="othersversions_selected" style="display:block;">
  <li class="active"><span onclick="DisplayOthers()"><a class="active">Fellows</span></a></li>
	</ul>
	</div><!-- box_title-->

 	<div class="box_content" id="otherversionspanel" style="display:block;">
		<table>
			{section name=i loop=$others}
	<tr><td><div style="float: left; padding-right:4px;"><img src="{$others[i][0]}" /> </div><span class="med_text"><span class="v_name">{$others[i][1]}</span><br /s>{$others[i][2]}</span></td></tr>
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
