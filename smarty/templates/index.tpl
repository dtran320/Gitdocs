{include file="header.tpl"}
<div class="container center_container">
<div class="left_side30">

<div class="box">
	<div class="box_title"></div>
	<div class="box_content">
		<div id="doc_link_left">
		<a href="editor.php">New</a>
		</div>
		<div id="doc_link_right">
		<a href="import.php">Upload</a>
		</div>
		<div id="doc_link_right">
		<a href="browse.php">Browse</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="box">
	<div class="box_title">My Recent Documents</div>
        <div class="box_content">
		<!-- don't change this id w/o changing references in gitdocs.js -->
		<table class="document_list" id="my_recent_docs">
		{if $my_recent_docs|@count == 0}
			You don't have any notes yet. <a href="editor.php">Take notes!</a>
		{/if}
		
		{section name=i loop=$my_recent_docs}
		<tr onclick="window.location='{$my_recent_docs[i].link}'">
			<td><strong>{$my_recent_docs[i].course}</strong>{$my_recent_docs[i].dName} {$my_recent_docs[i].vName}</td><td class="time small_text " id="{$recent_global_docs[i].timestamp}">{$my_recent_docs[i].timestamp}</td></tr>
		{/section}
		</table>
		<div style="padding-top:10px;"></div>	
		<div id="show_my_recent_docs"><a onclick="showAllMyDocuments();">See All My Documents</a></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end left side-->

<div class="right_side60">
	<div class="box">
		<div class="box_title">What my classmates are doing 
			
		<span id="filter" style="float:right;">
			<span class="option selected" id="All" onclick="setFilter('All')">All</span>
			{section name=i loop=$my_classes}
				| <span class="option" id="{$my_classes[i]}" onclick="setFilter('{$my_classes[i]}')">{$my_classes[i]}</span>
			{/section}
		</span>
		</div>
       	<div class="box_content">
			{if $my_recent_version_feed|@count == 0}
			You currently don't have any shared classnotes. <strong><a href="browse.php">Browse classes</a></strong>
			{/if}
				<table class="document_list" id="my_version_feed">					
					{section name=i loop=$my_recent_version_feed}
						<tr onclick="window.location='{$my_recent_version_feed[i].link}';"><td><img src="images/pix/{$my_recent_version_feed[i].uId}_small.jpg"></td><td>{$my_recent_version_feed[i].displayName} saved a version of </td><td><p>{$my_recent_version_feed[i].dName} {$my_recent_version_feed[i].vName}</p></td><td><p class="time small_text" id="{$my_recent_version_feed[i].timestamp}">{$my_recent_version_feed[i].timestamp}</p></td></tr>
					{/section}
						</table>
				</div><!-- end box content -->
	</div>

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
