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
		<table>
		{section name=i loop=$my_recent_docs}
		<tr><td><a href="{$my_recent_docs[i].link}"><p class="no_line_height">{$my_recent_docs[i].dName} - {$my_recent_docs[i].vName}</p><p class="small_text no_line_height">{$my_recent_docs[i].timestamp}</p></a></td></tr>
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
			<tr><td><span style="color:{cycle values="#1E1E1F, #67666A, #807F83, #CBC9CF"}">{$pop_tops[i]}</span></td></tr>
	<!-- el gray from kuler -->
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
