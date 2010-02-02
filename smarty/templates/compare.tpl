{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">Comparing -- {$d_name} <a href="compare_inline.php" style="color:red;">==AB TESTING CLICK HERE==</a></div>
	<div class="box_content">
	<table class="diff">
	<tr><th></th><th></th><th>your <span class="v_name">{$v_name}</span></th>
	<th></th><th>{$other_u_name}'s <span class="v_name">{$other_v_name}</span></th>
	<th><span class="likedislike"><span class="like" onclick="likeAll();">L</span> | <span class="dislike" onclick="dislikeAll();">D</span> |<span class="undo" onclick="undoAll();">U</span></span></th>
	</tr>
	{$diff}
	</table>
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	<ul class = "tabs primary" id ="myversions_selected" style="display:none">
		<li class = "active" id="myversions_tab"><span onclick="DisplayMine()"><a class="active">History</a></span></li>
		<li><span onclick="DisplayOthers()"><a>Classmates</a></span></li>
	</ul>
	<ul class="tabs primary" id="othersversions_selected" style="display:block;">
	 <li id="myversions_tab"><span onclick="DisplayMine()"><a>History</span></a></li>
	 <li class="active"><span onclick="DisplayOthers()"><a class="active">Classmates</span></a></li>
	</ul>
	</div><!-- box_title-->
  <div class="box_content" id="myversionspanel" style="display:none;">
  	<table>
			{section name=i loop=$history}	
				<tr><td><div style="float: {$history[i][0]}; padding-left: 6px; padding-right:6px;"><img src="{$history[i][1]}" /> </div><div class="med_text align_{$history[i][0]}">{$history[i][2]}</div></td></tr>
			{/section}
		</table> 
	</div>
	
	<div class="box_content" id="otherversionspanel" style="display:block;">
		<table style="width:100%">
			{section name=i loop=$others}	
			<tr><td id="td_{$smarty.section.i.index}"
					class="selectable {if $smarty.section.i.index == 0}selected{/if}"
					onclick="change_selection({$smarty.section.i.index})">
					<div style="float: left; padding-right:6px;"><img src="{$others[i][0]}" /> </div>
					<div class="med_text"> 
						<span style="float:left">{$others[i][1]}</span>
						<a class="comparable">compare</a>
					</div>
			</td></tr>
			{/section}
		</table>
	<p>get rid of line#'s later, but how will we segment the diff? per paragraph too course grain(?), per word too fine grain. per sentence?</p>	
	</div>
</div>

{include file="footer.tpl"}
