{include file="header.tpl"}
<div class="box left_main">
	<div class="box_title">Create a new note... as easy as 1, 2!
	</div>
	<div class="box_content">
	<form id="new_form" action="actions/createdoc.php" method="post">
	<table class="new_document">
			<td><img src="images/glass_numbers_1.png" height="30px"></td>
			<td class="left">What class are these notes for?</td>
			<td><input type="text" id="class_name" name="class_name" value="" placeholder="e.g. CS 294H, IHUM 5A" /></td>
		</tr>
		<tr>
			<td> </td>
			<td class="left">What type of notes are these?</td>
			<td><input id="lecture" type="radio" name="type" value="lecture" checked/> 	Lecture notes
				<input id="reading" type="radio" name="type" value="reading" /> Reading response</td>
		</tr>
		<tr>
			<td> </td>
			<td class="left">What day are these notes for?</td>
			<td><div id="datepicker"></div><input id="date" type="hidden" name="date" value=""/></td>
		</tr>
		<tr>
			<td> </td>
			<td class="left">Optional title:</td>
			<td><input type="text" name="title" id="note_title" value="" placeholder="e.g. Anh article"/></td>
		</tr>
		<tr>
			<td><img src="images/glass_numbers_2.png" height="30px"></td>
			<td class="left" colspan="2"><input type="submit" name="create" value="New Blank Document" /><input type="submit" name="create" value="Upload Existing Word Document"/></td>
		</tr>
	</table>
	</form>
	<div class="error" id="new_note_error" style="display: none;"></div>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	what should go here?
	</div><!-- box_title-->
 	<div class="box_content" id="otherversionspanel" style="display:block;">
		useful navigation would be nice
<br/><br/>
validate radio button on submit

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
	
		$('#class_name').placeholder();
		$('#note_title').placeholder();
		});

		function preCreateDoc() {
			var class_name = $("#class_name").val();
			var date = $("#date").val();
			var error = "";
			if (class_name == "") {
				error += "Please specify the class."
			}

			if (date == "") {
				error += "\nPlease specify the date.";				
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
				window.location = "upload.php?title=" + title + "&amp;class_name=" + class_name;
			}
			else {
				$('#new_note_error').html(response["error"]).show();
			}
		}



	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
