<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$action = postVarClean("action");

if($user = User::getLoggedInUser()) {
	$my_recent_docs = $user->getRecentDocumentsClean();
	echo json_encode($my_recent_docs);
}
else echo "0";

?>
