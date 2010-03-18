<?php
session_start();
require_once('classes/user.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');

$status = getVar('status');

if($status=='login') {
	$smarty->assign('error', 'You must be logged in to do that.');
}

$twitter_updates = getGitdocsUpdates(3);
$smarty->assign('twitter_updates', $twitter_updates);

$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
$smarty->assign('recent_global_docs', $recent_global_docs);
$smarty->assign('gitdocs_description', "<p style='float: center;'><img src='images/gitdocs_landing_350x200_blue.png'></p>");
$smarty->display('signup.tpl');

?>
