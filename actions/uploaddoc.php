<?php
session_start();
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . '/../lib/convert.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/version.php');

$random = md5(time() . rand(0, 1000));
$random = substr($random, 0, 10);
$doc_filename = $DOCUMENTS_PATH . "tmp/document-{$random}.doc";

$doc_title = getDocTitle($_FILES['uploadedfile']['name']);
if($doc_title) {
	$user_title = getVar('title');
	$class_name = getVar('class_name');
	if($user_title) $doc_title = $user_title;
  if($user = User::getLoggedInUser()) {
    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $doc_filename)) {
      $htmlFile = getHtmlFromWordDoc($doc_filename);
      $document = Document::CreateNewDocument($doc_title);
	if($class_name) $document->renameClass($class_name);
      $version = Version::CreateNewVersion($document->docId, $user->userId);
      $version->publish($htmlFile['content']);

      echo $version->versionId;
    } else{
      echo "There was an error uploading the file, please try again!";
    }
  }else {
    echo "You must be logged in to do that!";
  }
}// end if doc title
else {
  echo "You must upload a .doc or .docx file";
}

?>