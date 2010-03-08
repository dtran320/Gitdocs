{include file="header.tpl"}
<div class="box left_main">
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
	{if isset($timestamp)}
		<div class="old_timestamp">You are viewing an old revision from <span class="time" id="{$timestamp}">{$timestamp}</span></div>
	{/if}
		<div style="float: left; margin-left: 10px;">
			<form id="editor_form" class="big_form" method="post" action="editor.php" style="float:right;">
				<input type="hidden" name="action" value="{$action}" />
				<input type="hidden" name="document_id" value="{$d_id}" />
				<input type="hidden" name="clone_id" value="{$v_id}" />
				<input type="hidden" name="description" value="{$v_name}" />
				<input type="submit" name="submit" value="{$submit_text}"/>
			</form>
		</div>
		<div class="clear_fix"></div>
		<form id="doc_title" class="doc_title">
		<div class="box_title">
			<div style="float: left;">
				<table>
				<tr>
					<td><label for "change_class">Class:</td>
					<td><input type="text" id="change_class" name="change_class" value="{$class_name}" /></td>
				</tr>
				<tr>
					<td colspan="2">{$d_info}</td>
				</tr>
				<tr>
					<td><label for "change_d_name">Title:</td>
					<td><input type="text" id="change_d_name" name="change_d_name" value="{$d_name}" /></td>
				</tr>
				<tr>
					<td><label for "change_v_name">Description:</td>
					<td><input type="text" id="change_v_name" name="change_v_name" class="v_name" value="{$v_name}" /></td>
				</tr>
				</tr>
			</table>

			</div>
		</form>
		<div class="clear_fix"></div>

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
					class="selectable {if $others[i].vid == $v_id}selected{/if}" 
					onclick="change_selection({$smarty.section.i.index}, {$others[i].vid})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i].iconPtr}" /></div>
					<div class="med_text">
						<span style="float:left">{$others[i].names}</span>
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
