{include file='header.tpl'}

<div class="help_dropdown" id="compare_help_dropdown">
	<div class="box_title_unrounded">What is this page?</div>
	<div class="link float_right" onclick="closeDropdown();"><img src="images/fam_fam_icons/cancel.png">Close</div>
	<div class="diff_changes">
		<div class="change_bubble your_changes"> Your text</div> This shows text that appears in your version of the document, but not in mlee's.
		<div class="change_bubble their_changes">mlee's text</div> This shows text that appears in mlee's version of the document, but not in yours.
	</div>
</div><!-- compare_help_dropdown-->

<div class="container">
<div id="actions" class="box">
	<div class="box_title">Actions</div>
	<div class="box_content">
		<button class="big_button" id="accept_all" onclick="acceptAllChanges()">Accept all remaining (4)</button>
		<button class="big_button" id="reject_all" onclick="rejectAllChanges()">Reject all remaining (4)</button>
	<div class="float_right">
		<button class="big_button" id="save" onclick="window.location.href='compared.php'">Save</button>
		<div class="spacer100"></div>
		<button class="big_button" id="cancel" onclick="window.location.href='editor.php'">Cancel</button>
	</div>
	</div>
</div>

<div class="box left_main">
	<div class="box_title">Comparing your "{$v_name}" with {$other_u_name}'s "{$other_v_name}"</div>
	<div class="box_content">
		<div class="diff_changes">
			<div class="bubble_spacer"></div>
			<div class="bubble_spacer"></div>
			<div class="change_bubble your_changes_icon" id="change_bubble1">
				mlinsey: who was...
				<div class="float_right" id="bubble_merge1">
					<img src="images/fam_fam_icons/accept.png" class="icon_button" onclick="acceptChange(1)">
					<img src="images/fam_fam_icons/cancel.png" class="icon_button" onclick="rejectChange(1)">
				</div>
			</div>
			
			<div class="bubble_spacer"></div>
			<div class="change_bubble their_changes_icon" id="change_bubble2">mlee: rolled his...
				<div class="float_right" id="bubble_merge2">
					<img src="images/fam_fam_icons/accept.png" class="icon_button" onclick="acceptChange(2)">
					<img src="images/fam_fam_icons/cancel.png" class="icon_button" onclick="rejectChange(2)">
				</div>
			</div>
			<div class="bubble_spacer"></div>
				<div class="change_bubble their_changes_icon" id="change_bubble3">mlee: - their fourth...
				<div class="float_right" id="bubble_merge3">
					<img src="images/fam_fam_icons/accept.png" class="icon_button" onclick="acceptChange(3)">
					<img src="images/fam_fam_icons/cancel.png" class="icon_button" onclick="rejectChange(3)">
				</div>
			</div>
			<div class="bubble_spacer"></div>
			<div class="bubble_spacer"></div>
			<div class="change_bubble their_changes_icon" id="change_bubble4">mlee: - proba...
				<div class="float_right" id="bubble_merge4">	
					<img src="images/fam_fam_icons/accept.png" class="icon_button" onclick="acceptChange(4)">
					<img src="images/fam_fam_icons/cancel.png" class="icon_button" onclick="rejectChange(4)">
				</div>
			</div>
			
		</div>
		<div class="text_body">
			<!-- Story snippet borrowed from http://www.fanfiction.net/s/5161854/7/The_Fan -->
	{$v_text}
		</div>
	</div>
</div><!-- end left-->
<div class="box right_side">
        <div class="box_title">
	
	Comparing Versions

	</div><!-- box_title-->

	<div class="box_content" id="otherversionspanel" style="display:block;">
	<table>
		<tr><td class="your_changes"><div style="float: left;"><img src="images/mlinsey.jpg" /> </div>forest2<i> editing now</i><br />by mlinsey 5m ago</td></tr>
		<tr><td>Compared to</td></tr>
<tr><td class="their_changes"><div style="float: left;"><img src="images/mlee.jpg" /> </div>new desc. of Edward<br />by mlee 8h ago</td></tr>


</div><!-- end container-->

{include file='footer.tpl'}
