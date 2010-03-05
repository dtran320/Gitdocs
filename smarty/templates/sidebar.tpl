
  <div class="box_title">
	<ul class = "tabs primary" id ="myversions_selected" style="display:none;">
		<li ><span onclick="DisplayOthers()"><a>Classmates</a></span></li>
		<li class = "active" id="myversions_tab"><span onclick="DisplayMine()"><a class="active">History</a></span></li>
	</ul>
	<ul class="tabs primary" id="othersversions_selected">
	 <li class="active"><span onclick="DisplayOthers()"><a class="active">Classmates</a></span></li>
	 <li id="myversions_tab"><span onclick="DisplayMine()"><a>History</a></span></li>
	</ul>
	</div><!-- box_title-->
  <div class="box_content" id="myversionspanel" style="display:none;">
  	<table>
			{section name=i loop=$history}	
				<tr><td><a href="viewer.php?v_id={$v_id}&r_id={$history[i].hash}">{$history[i].revision}</a></td><td><td class="time" id="{$history[i].time}">{$history[i].time}</td></tr>
			{/section}
		</table> 
	</div>
	
	<div class="box_content" id="otherversionspanel" style="display:block;">
			<table style="width:100%">
			{if $others|@count == 0}
			None of your classmates have a version of this yet!
			{/if}
			<tr><td class="selectable" colspan="2" onclick="window.location='viewall.php?d_id={$d_id}';"><a class="v_name">view all</a></td></tr>
			{section name=i loop=$others}	
			<tr><td id="td_{$smarty.section.i.index}"
					class="selectable"
					onclick="change_selection({$smarty.section.i.index}, {$others[i].vid})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i].iconPtr}" /> </div>
						<span class="med_text" style="float:left">{$others[i].names}</span>
				</td><td class="selectable med_text comparable" onclick="$('#other_u_id').val('{$others[i].uid}'); $('#compare_form').submit();">
						<a>compare</a>
			</td></tr>
			{/section}
		</table>
	</div>
</div>
