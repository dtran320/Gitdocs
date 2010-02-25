{include file="header.tpl"}
<div class="container center_container">
<div class="box" style="width: 980px">
	<div class="box_title">Choose a course</div>
  <div class="box_content">
		<table id="class_list" class="document_list" style="float: left; width:100px;">
			{section name=i loop=$all_classes}	
				<tr><td onclick="showNotesForClass('{$all_classes[i]}');"><p>{$all_classes[i]}</p></td></tr>
			{/section}
		</table>
		<table class="document_list" id="notes_for_class" style="width: 600px;">
		</table>
		<div style="float: right;width: 280px;" id="avatars"></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end container -->

{include file="footer.tpl"}
