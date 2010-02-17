<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

if($user = User::getLoggedInUser()) {
	$my_version_feed = $user->getRecentVersionFeedClean(5);
	echo json_encode($my_version_feed);
}
else echo "0";

?>
