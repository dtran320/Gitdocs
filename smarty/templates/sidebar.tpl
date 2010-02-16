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
			<tr><td class="selectable" colspan="2" onclick="window.location='viewall.php?d_id={$d_id}';"><a class="v_name">view everyone's notes</a></td></tr>
			{section name=i loop=$others}	
			<tr><td id="td_{$smarty.section.i.index}"
					class="selectable"
					onclick="change_selection({$smarty.section.i.index}, {$others[i][3]})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i][0]}" /> </div>
						<span class="med_text" style="float:left">{$others[i][1]}</span>
				</td><td class="selectable med_text comparable" onclick="$('#other_u_id').val('{$others[i][2]}'); $('#compare_form').submit();">
						<a>compare</a>
			</td></tr>
			{/section}
		</table>
	</div>
</div>
