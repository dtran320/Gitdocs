{include file="header.tpl"}
<div style="width: 1370px;">
<div class="box" style="float: left; width: 520px;">
	<div class="box_title">Create a new note
	</div>
	<div class="box_content">
	<form id="new_form" action="actions/createdoc.php" method="post">
	<table class="new_document">
			<td class="left">Class:</td>
			<td><input type="text" id="class_name" name="class_name" value="" placeholder="{$class_placeholder}" /></td>
		</tr>
		<tr>
			<td class="left">Type:</td>
			<td><input id="lecture" type="radio" name="type" value="lecture" onclick="ShowCalendar()" checked/> 	Lecture notes
				<input id="reading" type="radio" name="type" value="reading" onclick="ShowCalendar()"  /> Reading response
				<input id="final" type="radio" name="type" value="final" onclick="HideCalendar()" /> Final Study Guide
		</td>
				
		</tr>
		<tr>
			<td class="left"><div id="datelabel">Date:</div></td>
			<td><div id="datepicker"></div><input id="date" type="hidden" name="date" value=""/></td>
		</tr>
		<tr>
			<td class="left">Title:</td>
			<td><input type="text" name="title" id="note_title" value="" placeholder="{$title_placeholder}"/></td>
		</tr>
		<tr>
			<td class="left" colspan="2"><input type="submit" name="create" value="New Blank Document" /><input type="submit" name="create" value="Upload Word Document"/></td>
		</tr>
	</table>
	</form>
	<div class="error" id="new_note_error" style="display: none;"></div>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box" style="width: 850px;float: right;">
<div class="box_title" id="other_notes_header">
</div><!-- box_title-->
<div class="box_content">
		<table id="notes_for_class">
		</table>

</div>
</div>
</div>
	<script type="text/javascript">
	{literal}

	//<![CDATA[
		$(document).ready(function(){
			var classes = '{/literal}{$all_classes}{literal}'.split(',');
			$('#class_name').autocomplete(classes);
			$('#datepicker').datepicker({
				onSelect: function(dateText, inst) {
					$('#date').val(dateText);
				}
			});
	    $('#new_form').ajaxForm({ 
			dataType:      'json', 
	        beforeSubmit:  preCreateDoc,  // pre-submit callback 
	        success:       postCreateDoc  // post-submit callback 
	    });
	
		$('#class_name').placeholder({
			}).blur(enteredClass).unbind("keypress").keypress(function(e) {
					if (e.keyCode == 13) {
						enteredClass();
					}
			});

		$('#note_title').placeholder({
		});
		});

		function enteredClass() {
			var class_name = $('#class_name').val();
			if (class_name == '' || class_name == '{/literal}{$class_placeholder}{literal}') {
				$('#notes_for_class').html('');
				$('#other_notes_header').html('');
			} else {
					$('#other_notes_header').html('Other notes in ' + class_name);
					showNotesForClass(class_name);
			}		
		}
		function preCreateDoc() {
			var class_name = $("#class_name").val();
			var date = $("#date").val();
			var final =$("#final:checked").val();
			var title = $("#note_title").val();
			var error = "";
			if (class_name == "" || class_name == "{/literal}{$class_placeholder}{literal}") {
				error += "Please specify the class.";
			}
			if ((date == "") && (final != "final")) {
				error += "\nPlease specify the date.";				
			}				

			if (title == "" || title=="{/literal}{$title_placeholder}{literal}") {
				error += "\nPlease specify the title.";
			}
			if (error != "") {
				alert (error);
				return false;
			}
			return true;
		}

		function postCreateDoc(response) {
			if (response["result"] == "exists") {
				var d_id = response["d_id"];
				alert("A classmate has already created these notes!  We are going to whisk you to a magical place to view what's been noted so far...");
				window.location = "viewall.php?d_id=" + d_id;
			} else if (response["result"] == "create") {
				var v_id = response["v_id"];
				window.location = "editor.php?v_id=" + v_id;
			} 
			else if(response["result"] == "upload") {
				var title = response["title"];
				var class_name = response["class"];
				window.location = "upload.php?title=" + title + "&class_name=" + class_name;
			}
			else {
				$('#new_note_error').html(response["error"]).show();
			}
		}



	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
