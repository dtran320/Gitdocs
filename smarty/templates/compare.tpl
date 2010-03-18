{include file="header.tpl"}

		<form id="compare_form" action="compare_2col.php" method="post" style="display:none;">
			<input type="hidden" name="d_id" value="{$d_id}" />
			<input type="hidden" name="u_id" value="{$u_id}" />
			<input type="hidden" id="other_u_id" name="other_u_id" value="{$other_u_id}" />
		</form>

<div class="box left_main">
	<div class="box_title">Comparing -- {$d_name} <form id="merge_form" action="compare_post.php" method="post"><input type="submit" value="Save">
<input type="hidden" name="v_id" value="{$v_id}" />
<input type="hidden" name="other_v_id" value="{$other_v_id}"/>
</form></div>
	<div class="box_content">
	<div style="width: 600px; font-size: 13px;">
	<div id="column_top" style="width: 300px; float: left;">your <span class="v_name">{$v_name}</span></div>
	<div style="width: 300px; float: right;">{$other_u_name}'s <span class="v_name">{$other_v_name}</span></div>
	<div class="likedislike" style="position: absolute;"><span class="likeall" onclick="makeAllMergeChoices_2col('like');">A</span><span class="dislikeall" onclick="makeAllMergeChoices_2col('dislike');">R</span> | <span class="undoall" onclick="makeAllMergeChoices_2col('undo');">U</span></div>
		{$diff}
	</div>
	</div> <!--box content-->
</div> <!--box left_main-->
<div class="box right_side">
{include file="sidebar.tpl"}
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
