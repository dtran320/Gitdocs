{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">{$d_name} -- <span class="v_name">{$v_name}</span> -- <span class="u_name">{$u_name}</span> 
<a style="font-weight:bold; float: right;" href="editor.php">Start working off this version.</a>

</div>
	<div class="box_content">
			<div id="loader"><img src="images/ajax-loader.gif"></div>
			<div>
			<form method="post">
				<textarea id="editor1">
				{$v_text}
				</textarea>
			</form>
			</div>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	<ul class="tabs primary" id="othersversions_selected" style="display:block;">
  <li class="active"><span onclick="DisplayOthers()"><a class="active">Classmates</span></a></li>
	</ul>
	</div><!-- box_title-->

 	<div class="box_content" id="otherversionspanel" style="display:block;">
		<table style="width:100%">
			{section name=i loop=$others}
			<tr><td id="td_{$smarty.section.i.index}" 
					class="selectable {if $smarty.section.i.index == 0}selected{/if}" 
					onclick="change_selection({$smarty.section.i.index})">
					<div style="float: left; padding-right:4px;"><img src="{$others[i][0]}" /></div>
					<span class="med_text"><a class="v_name">{$others[i][1]}</a><br /s>{$others[i][2]}</span>
			</td></tr>
			{/section}
		</table>
	</div>
	<p>clicking the above should replace the text to the left to the left in a box to the left</p>	
	<script type="text/javascript">
	{literal}
	//<![CDATA[
		CKEDITOR.config.toolbar = [];
		CKEDITOR.config.height = 	$(window).height() - 200;
		$(document).ready(function(){
			$("#editor1").ckeditor(hideLoader("loader"));			
		});

	//]]>
	{/literal}
	</script>

{include file="footer.tpl"}
