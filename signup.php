<?php
session_start();
require_once('classes/user.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');

$twitter_updates = getGitdocsUpdates(3);
$smarty->assign('twitter_updates', $twitter_updates);

$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
$smarty->assign('recent_global_docs', $recent_global_docs);
$smarty->assign('gitdocs_description', "<p>Why study for tests in isolation? Want to share notes but not sure how to do so effectively? 
Gitdocs allows you to upload your class notes and manage sections of notes from your classmates,
choosing only those contributions you feel will be helpful to your version of your notes.</p>");
$smarty->display('signup.tpl');

?>
