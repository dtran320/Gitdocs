<?

require_once('config.php');
session_start();
require_once('classes/user.php');
require_once('classes/document.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');


if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$all_classes = Document::getAllClasses();
	$smarty->assign('all_classes', $all_classes);
	
	$smarty->assign('class_placeholder', 'e.g. ANTHRO 101');
	$smarty->assign('title_placeholder', 'e.g. Lec 5 - Modernity');
	
	$smarty->display('new_note.tpl');
	
}
else {
	$twitter_updates = getGitdocsUpdates(3);
	$smarty->assign('twitter_updates', $twitter_updates);

	$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
	$smarty->assign('recent_global_docs', $recent_global_docs);
	$smarty->assign('gitdocs_description', "<p>Why study for tests in isolation? Want to share notes but not sure how to do so effectively? Gitdocs allows you to upload your class notes and manage sections of notes from your classmates, choosing only those contributions you feel will be helpful to your version of your notes.</p>");
}
else {
	$_SESSION['return_page'] = 'new_note.php';
	header('Location: signup.php?status=login');
}
?>
