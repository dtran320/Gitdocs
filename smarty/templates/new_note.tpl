{include file="header.tpl"}
<div class="box left_main">
	<div class="box_title">Create a new note
	</div>
	<div class="box_content">
	<form id="new_form" action="actions/createdoc.php" method="post">
	What class are these notes for?	<input type="text" id="class_name" name="class_name" value="" />
	<br/><br/>
	What type of notes are these? <input id="lecture" type="radio" name="type" value="lecture" checked/> 	Lecture notes
	<input id="reading" type="radio" name="type" value="reading" /> Reading response
	<br/><br/>
	What day are these notes for?
	<div id="datepicker" style="padding: 10px">
	</div>
	<br/>
	<input id="date" type="hidden" name="date" value=""/>
	Optional title: <input type="text" name="title" value=""/>
	<br/><br/>
	<input type="submit" value="Create" />
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
			else {
				$('#new_note_error').html(response["error"]).show();
			}
		}



	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
