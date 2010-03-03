{include file="header.tpl"}
<div class="container center_container">

<div class="box">
	<div class="box_title">{$num_results} Results for "{$query}". ({$query_time} ms)</div>
        <div class="box_content">
		<table class="document_list" id="my_recent_docs">
		{if $results|@count == 0}
			No results found.
		{/if}
		{section name=i loop=$results}
		<tr onclick="window.location='{$results[i].link}'">
			<td><strong>{$results[i].docName}</strong> {$results[i].name}</td><td><img src="{$results[i].iconPtr}"></td><td>{$results[i].userName}</td><td class="time small_text " id="{$results[i].last_modified}">{$results[i].last_modified}</td></tr>
		{/section}
		</table>
		<div style="padding-top:10px;"></div>	
	</div><!-- end box_content -->
</div><!-- end box -->

</div><!-- end container -->
{include file="footer.tpl"}
