<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

if($user = User::getLoggedInUser()) {
	
	$filter = postVarClean("filter");
	if($filter=="All") $filter = 0;
	$my_version_feed = $user->getRecentVersionFeedClean(8, $filter);
	echo json_encode($my_version_feed);
}
else echo "0";

?>
