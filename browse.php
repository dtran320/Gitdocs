<?
require_once('config.php');
if(DEBUG) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}

session_start();
require_once('classes/user.php');
require_once('classes/document.php');
require_once('lib/utils.php');
require('init_smarty.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	
	$all_classes = Document::getAllClasses();
	$all_classes = explode(",", $all_classes);
	$smarty->assign('all_classes', $all_classes);
	$smarty->display('browse.tpl');
} // end if user logged in
else {
	header('Location: signup.php');
}
?>
