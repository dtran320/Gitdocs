{include file="header.tpl"}

<div class="box left_main">
	<form class="reg_form">
	<div class="box_title">Editing -- {$d_name} -- <span class="v_name">{$v_name}</span> -- <span class="u_name">{$u_name}</span> 
		<span id="save_status" style="float:right;"></span>
		<form id="save_form" name="save_form" method="post" style="float:right;">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="d_id" value="{$d_id}" />
			<input type="hidden" name="u_id" value="{$u_id}" />
			<input type="hidden" name="doc_text" value="" />
			<input type="submit" style-"float:right;" name="submit" value="Save" onclick="saveVersion(event)"/>
		</form>
	</div>
	</form>
	<div class="box_content">
			<div id="loader"><img src="images/ajax-loader.gif"></div>
			<div>
			<form method="post">
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
						<a class="comparable" href="compare.php">compare</a>
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
		});
	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
