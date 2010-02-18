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
		{section name=i loop=$my_recent_docs}
		<tr><td><a href="{$my_recent_docs[i].link}"><p>{$my_recent_docs[i].dName} {$my_recent_docs[i].vName}</p><p class="time small_text " id="{$recent_global_docs[i].timestamp}">{$my_recent_docs[i].timestamp}</p></a></td></tr>
		{/section}
		</table>
		<div style="padding-top:10px;"></div>	
		<div id="show_my_recent_docs"><a onclick="showAllMyDocuments();">See All My Documents</a></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end left side-->

<div class="right_side60">
	<div class="box">
		<div class="box_title">What my classmates are doing</div>
       	<div class="box_content">
				<table class="document_list" id="my_version_feed">
					{section name=i loop=$my_recent_version_feed}
						<tr><td><img src="{$my_recent_version_feed[i].iconPtr}"></td><td>{$my_recent_version_feed[i].displayName} saved a version of </td><td><a href="{$my_recent_version_feed[i].link}"><p>{$my_recent_version_feed[i].dName} {$my_recent_version_feed[i].vName}</p></a></td><td><p class="time small_text" id="{$my_recent_version_feed[i].timestamp}">{$my_recent_version_feed[i].timestamp}</p></td></tr>
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
		setInterval(function(){ $.post("actions/getFeed.php", { "foo" : "bar" },
		   function(data){
			fetchRecentVersions(data); }, "json") }, 10000);
		setInterval(function(){ $(".time").prettyDate(); }, 10000);
	});
		//]]>
		{/literal}
	</script>
{include file="footer.tpl"}
