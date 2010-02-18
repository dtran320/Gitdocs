{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">
	<div style="float:left;"> Viewing -- {$d_name} -- <span class="v_name">{$v_name}</span> 
  -- <span class="u_name">{$author_name}</span>
	{if isset($timestamp)}
		<div class="old_timestamp">You are viewing an old revision from <span class="time" id="{$timestamp}">{$timestamp}</span></div>
	{/if}
	</div>
			<form id="editor_form" class="big_form" method="post" action="editor.php" style="float:right;">
				<input type="hidden" name="action" value="{$action}" />
				<input type="hidden" name="document_id" value="{$d_id}" />
				<input type="hidden" name="clone_id" value="{$v_id}" />
				<input type="hidden" name="description" value="{$v_name}" />
				<input type="submit" name="submit" value="{$submit_text}"/>
			</form>
		</div>
		<div class="clear_fix"></div>
	<div class="box_content">

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
			<tr><td class="selectable" colspan="2" onclick="window.location='viewall.php?d_id={$d_id}';"><a class="v_name">view all</a></td></tr>
			{section name=i loop=$others}
			<tr><td id="td_{$smarty.section.i.index}" 
					class="selectable {if $others[i][3] == $v_id}selected{/if}" 
					onclick="change_selection({$smarty.section.i.index}, {$others[i][3]})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i][0]}" /></div>
					<div class="med_text">
						<span style="float:left">{$others[i][1]}</span>
					</div>
			</td></tr>
			{/section}
		</table>
	</div>	
	<script type="text/javascript">
	{literal}
	//<![CDATA[
		CKEDITOR.config.toolbar = [];
		CKEDITOR.config.height = 	$(window).height() - 200;
		$(document).ready(function(){
			$("#editor1").ckeditor(hideLoader("loader"));	
			$(".time").prettyDate();		
		});

	//]]>
	{/literal}
	</script>

{include file="footer.tpl"}
