{include file="header.tpl"}

<div class="container center_container">
<div class="box">
	<div class="box_title">Change your avatar</div>
  <div class="box_content">
		<table>
		<tr>
		<td>
		<img src="lib/Jcrop/demos/demo_files/flowers.jpg" id="cropbox" />
		</td>
		<td>
		<div style="width:50px;height:50px;overflow:hidden;">
			<img src="lib/Jcrop/demos/demo_files/flowers.jpg" id="preview" />
		</div>
		
		</td>
		</tr>
		</table>
		<form id="crop_form" action="actions/crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" value="" />
			<input type="hidden" id="y" name="y" value="" />
			<input type="hidden" id="w" name="w" value="" />
			<input type="hidden" id="h" name="h" value="" />

			<input type="submit" value="Crop Image" />
		</form>
	<div id="crop_status"></div>
	</div><!-- end box_content -->

</div><!-- end box -->
</div><!-- end container -->

<script type="text/javascript">
	{literal}

	//<![CDATA[

		// from tutorial 3 of jcrop doc
		jQuery(window).load(function(){
			$('#cropbox').Jcrop({
				onChange: showPreview,
				onSelect: showPreview,
				aspectRatio: 1,
				setSelect: [ 0, 0, 100, 100 ]
			});

	    $('#crop_form').ajaxForm({ 	
        success:	postCrop  // post-submit callback 
	    });

		});

		function postCrop(response) {
			$("#crop_status").html(response);
		}
		
		function showPreview(coords)
		{
			if (parseInt(coords.w) > 0)
			{
				var rx = 50 / coords.w;
				var ry = 50 / coords.h;

				jQuery('#preview').css({
					width: Math.round(rx * 500) + 'px',
					height: Math.round(ry * 370) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
				
				updateCoords(coords);
				
			}
		}

		function updateCoords(c)
		{
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
		};

		function checkCoords()
		{
			if (parseInt($('#w').val())) return true;
			alert('Please select a crop region then press submit.');
			return false;
		};


		//]]>
	{/literal}
	</script>

{include file="footer.tpl"}
