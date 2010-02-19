<?
session_start();
require('init_smarty.php');
require('classes/user.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$smarty->display('change_avatar.tpl');

} else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
