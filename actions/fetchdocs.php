<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$action = postVarClean("action");

if($user = User::getLoggedInUser()) {
	$my_recent_docs = $user->getRecentDocuments();
	//preprocess to figure out links
	foreach($my_recent_docs as $k => $v) {
		$my_recent_docs[$k]["vName"] = stripslashes($my_recent_docs[$k]["vName"]);
		$my_recent_docs[$k]["dName"] = stripslashes($my_recent_docs[$k]["dName"]);
		$my_recent_docs[$k]["link"] = "editor.php?v_id=" . $my_recent_docs[$k]["vId"];
	}
	echo json_encode($my_recent_docs);
}
else echo "0";

?>
