{include file="header.tpl"}
<div class="">

<div class="container center_container">
<div class="left_side45">
<div class="box">
	<div class="box_title">Search Gitdocs</div>
	<div class="box_content">
	<form id="form_search" class="big_form" action="search.php" method="get">
	<input type="text" name="query" value="Find a document" />
	<input type="submit" value="Search" />
	</form>
	</div>
</div>

<div class="box">
	<div class="box_title">Create</div>
	<div class="box_content">
		<div id="doc_link_left">
		<a href="index.php">New Document</a>
		</div>
		<div id="doc_link_right">
		<a href="import.php">Upload document</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="box">
	<div class="box_title">My Recent Documents</div>
        <div class="box_content">
		<table>
		{section name=i loop=$my_recent_docs}
		<tr><td>{$my_recent_docs[i]}</td></tr>
		{/section}
		</table>
		<div style="padding-top:10px;">
		<a href="index.php">See All My Documents</a>
		</div>	
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end container col-->

<div class="right_side45">
<div class="box">
	<div class="box_title">Popular topics</div>
       	<div class="box_content">
		<div style="padding-bottom:20px;">
			<table>
			{section name=i loop=$pop_tops}
			<tr><td><span style="font-size:{cycle values="30px, 25px, 20px, 15px"}">{$pop_tops[i]}</span></td></tr>
			{/section}
			</table>
			</div>
		</div>
</div>

<div class="box">
	 <div class="box_title">Popular documents</div>
       <div class="box_content">
			<table>
			{section name=i loop=$pop_docs}
			<tr><td>{$pop_docs[i]}</td></tr>
			{/section}
			</table>
		</div>
</div>
</div>

</div><!-- end container -->

{include file="footer.tpl"}
