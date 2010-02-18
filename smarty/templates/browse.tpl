{include file="header.tpl"}
<div class="container center_container">
<div class="left_side30">
<div class="box">
	<div class="box_title">Choose a class</div>
  <div class="box_content">
		<table class="document_list">
			{section name=i loop=$all_classes}	
				<tr><td onclick="showNotesForClass('{$all_classes[i]}');"><p>{$all_classes[i]}</p></td></tr>
			{/section}
		</table>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end left side-->

<div class="right_side60">
	<div class="box">
		<div class="box_title"></div>
       	<div class="box_content">
				<table class="document_list" id="notes_for_class">
				</table>
				</div><!-- end box content -->
	</div>

</div> <!-- end right_side -->
</div><!-- end container -->

{include file="footer.tpl"}
