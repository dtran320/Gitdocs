{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">Viewing all notes about {$d_name}

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
				<img src="{$versions[i][1]}" />
				<span>{$versions[i][0]}</span> <!-- author name -->
				<span class="v_name">{$versions[i][2]}</span>
				{if !$userHasDoc}<a style="float: right;" onclick="
$('#editor_form input[name=clone_id]').val('{$versions[i][4]}');
$('#editor_form input[name=description]').val('{$versions[i][2]}');
$('#editor_form').submit();">Start working off this version</a>{/if}
				<span style="font-size:12px">{$versions[i][3]}</span>
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
