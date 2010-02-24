{include file="header.tpl"}

<div class="container center_container">
<div class="box">
	<div class="box_title">Upload a word document to Gitdocs:</div>
  <div class="box_content">
		<form id="upload_form" enctype="multipart/form-data" action="actions/uploaddoc.php" method="post">
			<input type="hidden" name="action" value="upload" />
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
			Choose a file to upload: <input name="uploadedfile" type="file" /><br />
			<input type="submit" value="Upload File" />
		</form>
  <div class="doc_preview" id="doc_preview">

  </div>


<script type="text/javascript">
	{literal}
	//<![CDATA[
		// from tutorial 3 of jcrop doc
           $(document).ready(function() {

	       $('#upload_form').ajaxForm({ 	
		 success: postUploadDoc,  // post-submit callback 
	       });
	     });

		function postUploadDoc(data) {
		  if(Number(data) > 0) {
		    $('#doc_preview').html('Successfully uploaded file. Redirecting you to it.');
		   window.location='editor.php?v_id=' + data;
		  }
		  else {
		    $('#doc_preview').html(data);
		  }
		}
		//]]>
	{/literal}
	</script>


{include file="footer.tpl"}
