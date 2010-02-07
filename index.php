<?
session_start();

require('classes/user.php');
require('init_smarty.php');

$action = getVar("action");
if($action == "logout") User::logout();

$smarty->assign('pop_tops', array("databases networks compilers os", "OOP closure languages", "datavis hci graphics siggraph", "anonymity identity audience cs294h"));

$smarty->assign('pop_docs', 
	array("<a href='viewer.php'>CS205A Notes</a>",  
"<a href='viewer.php'>CS145 Notes</a>",
"<a href='viewer.php'>CS294 Class Notes</a>", 
"<a href='viewer.php'>CS140 Notes</a>"));

if($user = User::getLoggedInUser()) {
	$my_recent_docs = $user->getRecentDocuments(3);
	
	$smarty->assign('my_recent_docs', $my_recent_docs);
	
	$smarty->assign('logged_in_user', $user->getUserInfo());

	$smarty->display('index.tpl');
}
else {
	$smarty->display('signup.tpl');
}
?>

