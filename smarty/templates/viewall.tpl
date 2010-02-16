{include file="header.tpl"}

<div class="box left_main">
	<div class="box_title">{$d_name} -- <span class="v_name">{$v_names}</span> --
			 <span class="u_name">{$author_names}</span> 
		</div>
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
	title
	</div><!-- box_title-->

 	<div class="box_content" id="otherversionspanel" style="display:block;">
		<p>hi there!</p>
	</div>	
</div>
{include file="footer.tpl"}
