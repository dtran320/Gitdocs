<?
session_start();
require('init_smarty.php');
require_once('config.php');
require_once('classes/user.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$smarty->assign('u_id', $user->userId);
	
	$smarty->assign('title', getVar('title'));
	$smarty->assign('class_name', getVar('title'));
	
	$smarty->display('upload.tpl');

} else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
