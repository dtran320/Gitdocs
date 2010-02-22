{include file="header.tpl"}
<div class="box left_main">
	<div class="box_title">Viewing all notes about {$d_name}
			<form id="compare_form" action="{if $u_id % 2 == 0}compare_2col.php {else}compare_2col.php{/if}" method="post" style="display:none;">
				<input type="hidden" name="d_id" value="{$d_id}" />
				<input type="hidden" name="u_id" value="{$u_id}" />
				<input type="hidden" id="other_u_id" name="other_u_id" value="" />
			</form>

			<form id="editor_form" class="big_form" method="post" action="editor.php" style="float:right;">
				<input type="hidden" name="action" value="clone" />
				<input type="hidden" name="document_id" value="{$d_id}" />
				<input type="hidden" name="clone_id" value="" />
				<input type="hidden" name="description" value="" />
				{if $userHasDoc}
					<input type="submit" name="submit" value="Go to my version"/>
				{/if}
			</form>

	</div>
		<div class="clear_fix"></div>
	<div class="box_content">

	{section name=i loop=$versions}	
				<div style="border-bottom: 1px solid #BBB; padding-top: 5px;">
				<img src="{$versions[i].iconPtr}" />
				<span>{$versions[i].author_name}</span> <!-- author name -->
				<span class="v_name">{$versions[i].v_name}</span>
				{if !$userHasDoc}
					<a style="float: right;" onclick="
						$('#editor_form input[name=clone_id]').val('{$versions[i].v_id}');
						$('#editor_form input[name=description]').val('{$versions[i].v_name}');
						$('#editor_form').submit();">Start working off this version</a>
				{else}
					{if $u_id != $versions[i].author_id}
					<a style="float: right;" onclick="
						$('#compare_form input[name=other_u_id]').val('{$versions[i].author_id}');
						$('#compare_form').submit();">Compare</a>
					{else}
					<a style="float: right;" onclick="$('#editor_form input[name=submit]').click();">Go to my version</a>
					{/if}
				{/if}
				<span style="font-size:12px">{$versions[i].v_text}</span>
				</div>
	{/section}
			
	</div> <!--box content-->
</div> <!--box left_main-->

<div class="box right_side">
  <div class="box_title">
	what should go here?
	</div><!-- box_title-->
 	<div class="box_content" id="otherversionspanel" style="display:block;">
		useful navigation would be nice
	</div>	
</div>
{include file="footer.tpl"}
