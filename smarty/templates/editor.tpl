{include file="header.tpl"}

<div class="box left_main">
	<form id="doc_title" class="doc_title">
	<div class="box_title">
		<div style="float: left;">Editing -- 
			<input type="text" id="change_d_name" name="change_d_name" value="{$d_name}"/> -- <input type="text" id="change_v_name" name="change_v_name" class="v_name" value="{$v_name}" /></span> -- <span class="u_name">{$displayName}</span> </div>
	</form>
	<form id="compare_form" action="{if $u_id % 2 == 0}compare_2col.php {else}compare_inline.php{/if}" method="post" style="display:none;">
		<input type="hidden" name="d_id" value="{$d_id}" />
		<input type="hidden" name="u_id" value="{$u_id}" />
		<input type="hidden" id="other_u_id" name="other_u_id" value="" />
	</form>
	
	<form id="save_form" class="big_form" action="actions/saveshare.php" method="post" style="float:right;">
		<input type="hidden" name="action" value="save" />
		<input type="hidden" name="d_id" value="{$d_id}" />
		<input type="hidden" name="u_id" value="{$u_id}" />
		<input type="submit" name="submit" value="Save" onclick="updateElement();"/>
		<input type="submit" name="submit" value="Publish" onclick="updateElement();"/>

	</div><!-- end box_title -->

		<div id="save_status" class="status"></div>
	<div class="clear_fix"></div>

	<div class="box_content">
			<div id="loader"><img src="images/ajax-loader.gif"></div>
			<div>
				<textarea name="editor1" id="editor1">
				{$v_text}
				</textarea>
			</form>
			</div>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	<ul class = "tabs primary" id ="myversions_selected">
		<li class = "active" id="myversions_tab"><span onclick="DisplayMine()"><a class="active">History</a></span></li>
		<li><span onclick="DisplayOthers()"><a>Classmates</a></span></li>
	</ul>
	<ul class="tabs primary" id="othersversions_selected" style="display:none;">
	 <li id="myversions_tab"><span onclick="DisplayMine()"><a>History</span></a></li>
	 <li class="active"><span onclick="DisplayOthers()"><a class="active">Classmates</span></a></li>
	</ul>
	</div><!-- box_title-->
  <div class="box_content" id="myversionspanel" style="display:block;">
  	<table>
			{section name=i loop=$history}	
				<tr><td><div style="float: {$history[i][0]}; padding-left: 6px; padding-right:6px;"><img src="{$history[i][1]}" /> </div><div class="med_text align_{$history[i][0]}">{$history[i][2]}</div></td></tr>
			{/section}
		</table> 
	</div>
	
	<div class="box_content" id="otherversionspanel" style="display:none;">
		<table style="width:100%">
			{if $others|@count == 0}
			None of your classmates have a version of this yet!
			{/if}
			{section name=i loop=$others}	
			<tr><td id="td_{$smarty.section.i.index}"
					class="selectable {if $smarty.section.i.index == 0}selected{/if}"
					onclick="change_selection({$smarty.section.i.index})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i][0]}" /> </div>
					<div class="med_text"> 
						<span style="float:left">{$others[i][1]}</span>
						<a class="comparable" onclick="$('#other_u_id').val('{$others[i][2]}'); $('#compare_form').submit();">compare</a>

					</div>
			</td></tr>
			{/section}
		</table>
	<p>what abt this interaction: clicking on these just shows their text (like in viewer.php), and then there is *another* click to do the diff view?</p>	
	</div>
</div>

	<script type="text/javascript">
	{literal}
	//<![CDATA[
		CKEDITOR.config.toolbar = [
				// for full toolbar: look at http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
				['Cut','Copy','Paste', '-', 'Undo','Redo'],
				['Bold','Italic','Underline'],
				['Font','FontSize'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Maximize']
		];
		CKEDITOR.config.height = 	$(window).height() - 200;
		$(document).ready(function(){
			$("#editor1").ckeditor(hideLoader("loader"));	
			// bind form using 'ajaxForm' 
		    $('#save_form').ajaxForm({ 
		        beforeSubmit:  preSaveVersion,  // pre-submit callback 
		        success:       postSaveVersion  // post-submit callback 
		    });
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

	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
