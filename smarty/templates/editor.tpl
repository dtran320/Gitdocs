{include file="header.tpl"}
<form id="save_form" class="big_form" action="actions/saveshare.php" method="post">
	<input type="hidden" name="d_id" value="{$d_id}" />
	<input type="hidden" name="u_id" value="{$u_id}" />
	
<div class="box left_main">
	<textarea name="editor1" id="editor1">
		{$v_text}
	</textarea>

</div> <!--box left_main-->
<div class="box right_side">
	<div style="margin-left: 10px; float: left;"><input type="submit" name="action" value="Save" onclick="updateElement();"/></div>
	<div id="save_status" class="status" style="float: right;"></div>
</form>
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
<form id="compare_form" action="compare_2col.php" method="post" style="display:none;">
	<input type="hidden" name="d_id" value="{$d_id}" />
	<input type="hidden" name="u_id" value="{$u_id}" />
	<input type="hidden" id="other_u_id" name="other_u_id" value="" />
</form>


</div><!-- end box_title -->
<div class="clear_fix"></div>
{include file="sidebar.tpl"}

	<script type="text/javascript">
	{literal}

	//<![CDATA[
		CKEDITOR.config.toolbar = [
				// for full toolbar: look at http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
				['Cut','Copy','Paste', '-', 'Undo','Redo'],
				['Bold','Italic','Underline', 'NumberedList','BulletedList'],
				['Font','FontSize'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Maximize', 'Source']
		];
		CKEDITOR.config.height = 	$(window).height() - 200;
		$(document).ready(function(){
			$("#editor1").ckeditor();
			// bind form using 'ajaxForm' 
		    $('#save_form').ajaxForm({ 
		        beforeSubmit:  preSaveVersion,  // pre-submit callback 
		        success:       postSaveVersion  // post-submit callback 
	    });
			var classes = '{/literal}{$all_classes}{literal}'.split(',');
			$('#change_class').autocomplete(classes);
		});

			//bind document and version names
			$('#change_d_name').mouseenter(function() {
				$('#change_d_name').addClass('highlighted'); 
				}).mouseleave(function() {
					$('#change_d_name').removeClass('highlighted');
				}).click(function() {
					changeDName('#change_d_name', '{/literal}{$d_id}{literal}');
				});
				
			$('#change_v_name').mouseenter(function() {
				$('#change_v_name').addClass('highlighted'); 
				}).mouseleave(function() {
					$('#change_v_name').removeClass('highlighted');
				}).click(function() {
					changeVName('#change_v_name', '{/literal}{$d_id}{literal}','{/literal}{$u_id}{literal}');
				});
				$(".time").prettyDate();
				

			var hasFocus = false;
			$('#change_class').mouseenter(function() {
				$('#change_class').addClass('highlighted'); 
				}).mouseleave(function() {
					if(!hasFocus) {
						$('#change_class').removeClass('highlighted');
					}
				}).result(function(event, data, formatted) {
						changeClass('#change_class', '{/literal}{$d_id}{literal}');
				}).focus(function() {
					hasFocus = true;
					$('#change_class').addClass('highlighted');
				}).blur(function() {
					hasFocus = false;
					changeClass('#change_class', '{/literal}{$d_id}{literal}');
					$('#change_class').removeClass('highlighted');
				}).unbind("keypress").keypress(function(e) {
					if (e.keyCode == 13) {
						changeClass('#change_class', '{/literal}{$d_id}{literal}');			
					}
				});
			// TODO: if user selects something from the dropdown, then fires twice.


	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
