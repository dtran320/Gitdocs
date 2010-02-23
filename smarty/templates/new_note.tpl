{include file="header.tpl"}
<div class="box left_main">
	<div class="box_title">Create a new note
	</div>
	<div class="box_content">
	<form>
	class goes here	<input type="text" id="class_name" name="class_name" value="" />
	<br/>
	type goes here 	<input type="radio" name="note_type" value="lecture" /> lecturenote
									<input type="radio" name="note_type" value="readingresponse" /> readingresponse
	<br/>
									<input type="submit" value="click me" />
	</form>

	<div id="datepicker">
	</div>

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
			$('#datepicker').datepicker();
		});
	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
