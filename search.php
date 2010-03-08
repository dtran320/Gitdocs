<?
require_once('config.php');
if(DEBUG) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}

session_start();
require_once('classes/user.php');
require_once('lib/utils.php');
require('init_smarty.php');
require_once('classes/version.php');
require_once('classes/document.php');
require_once('classes/searchEngine.php');

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$smarty->assign('u_id', $user->userId);
	$smarty->assign('displayName', $user->displayName);
	
	$query = getVarClean("query");
	if($query) { 
		$e = new SearchEngine();		
		$results = $e->runQuery($query);
		$smarty->assign('query', $query);
		$smarty->assign('query_time', $results["responseHeader"]["QTime"]);	
		$smarty->assign('num_results', $results["response"]["numFound"]);
		$smarty->assign('results', $results["response"]["docs"]);	
	}
	$smarty->display('search.tpl');

}//end if user logged in
else {
	header('Location: signup.php');
}
?>
