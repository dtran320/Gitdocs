<?php
session_start();
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/version.php');

$class_name = postVarClean('class_name');
$type = postVarClean('type');
$rawDate = postVarClean('date');
$date = $rawDate ? date("Y-m-d", strtotime(postVarClean('date'))) : "";
$title = postVarClean('title');

$create = postVarClean('create');

//$doc_title = Document::getNormalizedDocName($type, $date, $title);
$doc_title = $title != '' ? $title : 'untitled';


if($doc_title) {
	if($create =="New Blank Document") {
		if($user = User::getLoggedInUser()) {
			$existing_doc = Document::getDocForClassTypeAndDate($class_name, $type, $date);
			if($existing_doc) { //whisk away to existing doc
				$result_array = array('result' => 'exists', 'd_id' => $existing_doc);
			}
			else { //create new doc and redirect to it
				$document = Document::CreateNewDocument($doc_title, $class_name, $date, $type);
    		$version = Version::CreateNewVersion($document->docId, $user->userId);
				$result_array = array('result' => 'create', 'v_id' => $version->versionId);
			}
  	}
		else {
	  		$result_array = array('error' => 'Must be logged in.');
		}
	}
	else if ($create == "Upload Existing Word Document") {
		$result_array = array('result' => 'upload', 'title' => $doc_title, 'class' => $class_name);
	}
	else {
		$result_array = array('error' => 'Invalid action specified.');
	}
}// end if doc title
else {
	$result_array = array('error' => 'Invalid document info. Please try again.');
}

echo json_encode($result_array);


?>
