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
	
	$smarty->assign('class_placeholder', 'e.g. CS 294H, IHUM 5A');
	$smarty->assign('title_placeholder', 'e.g. Anh article');
	
	$smarty->display('new_note.tpl');
	
}
else {
	header('Location: signup.php');
}
?>
