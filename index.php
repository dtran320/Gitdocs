<?
require('init_smarty.php');

$my_recent_docs = array("doc1", "doc2", "doc3");
$smarty->assign('my_recent_docs', $my_recent_docs);

$smarty->assign('pop_tops', array("databases networks compilers os", "OOP closure languages", "datavis hci graphics siggraph", "anonymity identity audience cs294h"));

$smarty->assign('pop_docs', array("<a href='http://nytimes.com'>asdfasdfasfd</a>", "<a href='http://nytimes.com'>jkljkljkljlk</a>", "<a href='viewer.php'>Twilight!!</a>", "<a href='http://nytimes.com'>iopiopiop</a>"));

$smarty->display('index.tpl');
?>

