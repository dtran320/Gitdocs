{include file="header.tpl"}

		<form id="compare_form" action="compare_inline.php" method="post" style="display:none;">
			<input type="hidden" name="d_id" value="{$d_id}" />
			<input type="hidden" name="u_id" value="{$u_id}" />
			<input type="hidden" id="other_u_id" name="other_u_id" value="{$other_u_id}" />
		</form>

<div class="box left_main">
	<div class="box_title">Comparing -- {$d_name} <a onclick="$('#compare_form').submit();" style="color:red;">== click for other view (not bug-free)==</a><form id="merge_form" action="compare_post.php" method="post"><input type="submit" value="Save">
<input type="hidden" name="v_id" value="{$v_id}" />
<input type="hidden" name="other_v_id" value="{$other_v_id}"/>
</form></div>
	<div class="box_content">
	<div style="width: 600px; font-size: 13px;">
	<div id="column_top" style="width: 300px; float: left;">your <span class="v_name">{$v_name}</span></div>
	<div style="width: 300px; float: right;">{$other_u_name}'s <span class="v_name">{$other_v_name}</span></div>
	<div class="likedislike" style="position: absolute;"><span class="likeall" onclick="makeAllMergeChoices_2col('like');">L</span> | <span class="dislikeall" onclick="makeAllMergeChoices_2col('dislike');">D</span> | <span class="undoall" onclick="makeAllMergeChoices_2col('undo');">U</span></div>
		{$diff}
	</div>
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
	<script type="text/javascript">
	{literal}
	//<![CDATA[
		$(document).ready(function(){
			addLikeDislikeLinks('_2col');	
			placeLinks();
		});
	//]]>
	{/literal}
	</script>
{include file="footer.tpl"}
