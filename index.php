<? include('header.php'); ?>

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
			<tr><td>PhD Personal Statement</td></tr>
			<tr><td>CS147 Notes</td></tr>
			<tr><td>History Paper</td></tr>
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
			<tr><td><span style="font-size:30px">lorem ipsum dolor </span></td></tr>
			<tr><td><span style="font-size:25px">consectetur adipisicing</span></td></tr>
			<tr><td><span style="font-size:20px">ed do eiusmod tempor </span></td></tr>
			<tr><td><span style="font-size:15px">e et dolore magna aliqua occaecat</span></td></tr>
			</table>
			</div>
		</div>
</div>

<div class="box">
	 <div class="box_title">Popular documents</div>
       <div class="box_content">
			<table>
			<tr><td>How to Get Rich</td></tr>
			<tr><td><a href="viewer.php">Twilight Fanfic - Edward and Jacob!!</a></td></tr>
			<tr><td>Quantum Field Theory for Idiots</td></tr>
			</table>
		</div>
</div>
</div>

</div><!-- end container -->

<? include('footer.php'); ?>
