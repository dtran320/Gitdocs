<?php

session_start();
require_once('classes/user.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');

$action = getVar("action");
if($action == "logout") User::logout();

$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
$smarty->assign('recent_global_docs', $recent_global_docs);

if($user = User::getLoggedInUser()) {
	$smarty->assign('my_icon', getIconPtr($user->userId));
	$my_recent_docs = $user->getRecentDocumentsClean(8);
	//preprocess to figure out links
	$smarty->assign('my_recent_docs', $my_recent_docs);
	
	$smarty->assign('my_classes', $user->getClasses());
	
	$my_recent_version_feed = $user->getRecentVersionFeedClean(8);

	$smarty->assign('my_recent_version_feed', $my_recent_version_feed);
	
	$smarty->assign('logged_in_user', $user->getUserInfo());

	$smarty->display('index.tpl');
}
else {
	$twitter_updates = getGitdocsUpdates(3);
	$smarty->assign('twitter_updates', $twitter_updates);
	
	$smarty->display('signup.tpl');
}
?>

