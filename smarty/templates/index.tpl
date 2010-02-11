{include file="header.tpl"}
<div class="container center_container">
<div class="left_side45">

<div class="box">
	<div class="box_title"></div>
	<div class="box_content">
		<div id="doc_link_left">
		<a href="editor.php">New Notes</a>
		
		</div>
		<div id="doc_link_right">
		<a href="import.php">Upload Notes</a>
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
		<tr><td><a href="{$my_recent_docs[i].link}"><p class="no_line_height">{$my_recent_docs[i].dName} - {$my_recent_docs[i].vName}</p><p class="small_text no_line_height">{$my_recent_docs[i].timestamp}</p></a></td></tr>
		{/section}
		</table>
		<div style="padding-top:10px;"></div>	
		<div id="show_my_recent_docs"><a onclick="showAllMyDocuments();">See All My Documents</a></div>
	</div><!-- end box_content -->
</div><!-- end box -->
</div><!-- end left side-->

<div class="right_side45">

	<div class="box">
		<div class="box_title">Recently saved documents</div>
	       	<div class="box_content">
				<table class="document_list">
					{section name=i loop=$recent_global_docs}
						<tr><td>{$recent_global_docs[i].displayName}</td><td><a href="{$recent_global_docs[i].link}"><p class="no_line_height">{$recent_global_docs[i].dName} - {$recent_global_docs[i].vName}</p><p class="small_text no_line_height">{$recent_global_docs[i].timestamp}</p></a></td></tr>
					{/section}
						</table>
				</div><!-- end box content -->
			</div>
	
<div class="box">
	<div class="box_title">Popular topics</div>
       	<div class="box_content">
		<div style="padding-bottom:20px;">
			<table>
			{section name=i loop=$pop_tops}
			<tr><td><span style="color:{cycle values="#1E1E1F, #67666A, #807F83, #CBC9CF"}">{$pop_tops[i]}</span></td></tr>
	<!-- el gray from kuler -->
			{/section}
			</table>
			</div>
		</div><!-- end box content -->
</div> <!-- end box -->


<div class="box">
	 <div class="box_title">Popular documents</div>
       <div class="box_content">
			<table>
			{section name=i loop=$pop_docs}
			<tr><td>{$pop_docs[i]}</td></tr>
			{/section}
			</table>
		</div>
</div> <!-- end box -->

</div> <!-- end right_side -->
</div><!-- end container -->

{include file="footer.tpl"}
