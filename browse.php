<?
session_start();
require_once('classes/user.php');
require_once('classes/document.php');
require_once('lib/utils.php');
require('init_smarty.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
}
if($class = getVar('class')) $smarty->assign('class', $class);

	$all_classes = Document::getAllClasses();
	$all_classes = explode(",", $all_classes);
	$smarty->assign('all_classes', $all_classes);
	$smarty->display('browse.tpl');

?>
