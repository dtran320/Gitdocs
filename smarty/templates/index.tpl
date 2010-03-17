{include file="header.tpl"}
<div class="container center_container">
<div style="float: left; width: 300px;">

<div class="box">
	<div class="box_title"></div>
	<div class="box_content">
		<div id="doc_link">
		<a href="new_note.php"><button class="big"><img src="images/page_add.png">Add</button></a>
		</div>

		<div id="doc_link">
		<a href="browse.php"><button class="big"><img src="images/page_world.png">Browse</button></a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="box">
	<div class="box_title">My Recent Notes</div>
        <div class="box_content">
		<!-- don't change this id w/o changing references in gitdocs.js -->
		<div id="my_recent_docs">
		{foreach item=class from=$my_recent_docs}
		<table class="document_list">
		<tr><td><strong>{$class[0].course}</strong></td></tr>
		{if $my_recent_docs|@count == 0}
			You don't have any notes yet. <a href="new_note.php">Take notes!</a>
		{/if}
		{foreach item=note from=$class}
		<tr onclick="window.location='{$note.link}'">
			<td style="width:300px;"><span class="{$note.type}_title">{$note.dName}</span> -- {$note.vName}</td><td style="width:100px; text-align:right;" class="time small_text " id="{$note.timestamp}">{$note.timestamp}</td></tr>
		{/foreach}
		</table>
		{/foreach}
		</div>

		<div style="padding-top:10px;"></div>	
		<div id="show_my_recent_docs"><a onclick="showAllMyDocuments();">See All My Documents</a></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end left side-->

<div style="float: right; width: 600px; padding-left: 20px;">
	<div class="box">
		<div class="box_title">What my classmates are doing 
			
		<span id="filter" style="float:right; padding-right: 8px;">
			<select onchange="setFilter(this.options[this.selectedIndex].value)">
			<option class="option" id="All" value="All">All</option>
			{section name=i loop=$my_classes}
				<option class="option" id="{$my_classes[i]}" value="{$my_classes[i]}">{$my_classes[i]}</option>
			{/section}
			</select>
		</select>
		</span>
		</div>
       	<div class="box_content">
			{if $my_recent_version_feed|@count == 0}
			You currently don't have any shared classnotes. <strong><a href="browse.php">Browse classes</a></strong>
			{/if}
				<table class="document_list" id="my_version_feed">					
					{foreach item=doc from=$my_recent_version_feed}
						<tr><td colspan="3" style="background-color: #EEECEF;" onclick=window.location="viewall.php?d_id={$doc[0].dId}"><span class='bold {$doc[0].type}_title'>{$doc[0].dName}</span> -- {$doc[0].course}</td></tr>
						{foreach item=update from=$doc}
						<tr onclick=window.location="{$update.link}">
							<td style='width:500px;'><img style='padding:5px 5px 5px 10px;  float: left; vertical-align:middle;' src='{$update.iconPtr}'><div style="float: left; padding-top:10px;">{$update.vName}<br/><span class='username'>{$update.displayName}</span></div></td>
			
<td><p class='time small_text' id='{$update.timestamp}'> + {$update.timestamp}</p>
</td></tr>
						{/foreach}
					{/foreach}
				</table>
				</div><!-- end box content -->
	</div>
		<div class="box">
				<div class="box_title">Recently saved documents</div>
			       	<div class="box_content">
						<table class="document_list" id="recent_global">
							{section name=i loop=$recent_global_docs}
								<tr onclick="window.location='{$recent_global_docs[i].link};'">
									<td><img src="{$recent_global_docs[i].iconPtr}"></td>
									<td><p><span class="username">{$recent_global_docs[i].displayName}</span> saved <span class="lecture_title bold">{$recent_global_docs[i].dName}</span> <span class="v_name">{$recent_global_docs[i].vName}</span></p></td><td><p class="time small_text" id="{$recent_global_docs[i].timestamp}">{$recent_global_docs[i].timestamp}</p></a></td></tr>
							{/section}
								</table>
						</div><!-- end box content -->
			</div><!-- end box -->
</div> <!-- end right_side -->
</div><!-- end container -->
<script type="text/javascript">
	{literal}
	//<![CDATA[
	$(document).ready(function() {
		$(".time").prettyDate();
		setInterval(function(){ $.post("actions/getfeed.php", { "filter" : $('#filter .selected').text() },
		   function(data){
			fetchRecentVersions(data); }, "json") }, 10000);
		setInterval(function(){ $(".time").prettyDate(); }, 10000);
	});
		//]]>
		{/literal}
	</script>
{include file="footer.tpl"}
