<?
session_start();
require_once('classes/user.php');
require_once('classes/version.php');
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
	$my_recent_docs = $user->getRecentDocuments(5);
	//preprocess to figure out links
	foreach($my_recent_docs as $k => $v) 
		$my_recent_docs[$k]["link"] = "editor.php?v_id=" . $my_recent_docs[$k]["vId"];

	$recent_global_docs = Version::getRecentGlobalVersions(5);
	foreach($recent_global_docs as $k => $v) 
		$recent_global_docs[$k]["link"] = "viewer.php?v_id=" . $recent_global_docs[$k]["vId"];
		
	$smarty->assign('recent_global_docs', $recent_global_docs);
	
	$smarty->assign('my_recent_docs', $my_recent_docs);
	
	$smarty->assign('logged_in_user', $user->getUserInfo());

	$smarty->display('index.tpl');
}
else {
	$smarty->display('signup.tpl');
}
?>

