<?php
session_start();
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . '/../lib/convert.php');

$doc = postVar('doc');
echo $doc;

$random = md5(time() . "gitdocs");
$random = substr($random, 0, 6);
$doc_filename = $DOCUMENTS_PATH . "tmp/document-{$random}.doc";
echo $doc_filename;
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $doc_filename)) {
	$htmlFile = getHtmlFromWordDoc($doc_filename);
	echo $htmlFile? json_encode($htmlFile) : "0";
} else{
  echo "There was an error uploading the file, please try again!";
}


?>