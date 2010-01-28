<?
require('init_smarty.php');

$my_recent_docs = array("doc1", "doc2", "doc3");
$smarty->assign('my_recent_docs', $my_recent_docs);

$smarty->assign('pop_tops', array("databases networks compilers os", "OOP closure languages", "datavis hci graphics siggraph", "anonymity identity audience cs294h"));

$smarty->assign('pop_docs', 
	array("<a href='viewer.php'>CS205A Notes</a>",  
"<a href='viewer.php'>CS145 Notes</a>",
"<a href='viewer.php'>CS294 Class Notes</a>", 
"<a href='viewer.php'>CS140 Notes</a>"));

$logged_in_user = array(
						"iconPtr" => "images/mlinsey.jpg",
						"displayName" => "Mark Linsey"
						);

$smarty->assign('logged_in_user', $logged_in_user);

$smarty->display('index.tpl');
?>

