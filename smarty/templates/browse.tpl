{include file="header.tpl"}
<div class="container center_container">
<div class="box">
	<div class="box_title">Choose a course</div>
  <div class="box_content">
		<table id="class_list" class="document_list" style="float: left;">
			{section name=i loop=$all_classes}	
				<tr><td onclick="showNotesForClass('{$all_classes[i]}');"><p>{$all_classes[i]}</p></td></tr>
			{/section}
		</table>
		<table style="float: left; background:#EEECEF;" class="document_list" id="notes_for_class">
		</table>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end container -->

{include file="footer.tpl"}
