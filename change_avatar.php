<?
session_start();
require('init_smarty.php');
require_once('config.php');
require_once('classes/user.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$smarty->assign('u_id', $user->userId);
	$smarty->assign('avatar_exists', file_exists('images/pix/' . $user->userId . '_big.jpg'));
	$smarty->display('change_avatar.tpl');

} else {
	header('Location: signup.php');
}
?>
