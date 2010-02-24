<?

require_once('config.php');
session_start();
require_once('classes/user.php');
require_once('classes/document.php');
require('init_smarty.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$all_classes = Document::getAllClasses();
	$smarty->assign('all_classes', $all_classes);
	$smarty->display('new_note.tpl');
}
else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
