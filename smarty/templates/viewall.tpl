{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">Viewing all -- {$d_name}</div>
		<div class="clear_fix"></div>
	<div class="box_content">

	{section name=i loop=$versions}	
				<div style="border-bottom: 1px solid #BBB; padding-top: 5px;">
				<img src="{$versions[i][1]}" />
				{$versions[i][0]}
				<span class="v_name">{$versions[i][2]}</span>
				<span class="" style="font-size:12px">{$versions[i][3]}</span>
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
