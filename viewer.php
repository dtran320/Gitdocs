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

if($user = User::getLoggedInUser()) {
	$smarty->assign('logged_in_user', $user->getUserInfo());
	$smarty->assign('u_id', $user->userId);
	$smarty->assign('u_name', $user->username);
	$smarty->assign('displayName', $user->displayName);
	
	$v_id = getVarClean("v_id");
	if($v_id) { //opening an existing doc
		$version = new Version(0,0,0,0, $v_id);
		if ($version->getUserId() == $user->userId) {	
			header('Location: editor.php?v_id='.$v_id);
			exit(0);	
		}

		$versionName = $version->getName();
		$docText = $version->getDocFromDisk();
		$document = $version->getDocument();
		$smarty->assign('d_id', $document->docId);
		$smarty->assign('d_name', $document->name);
		$smarty->assign('v_id', $v_id);
		$smarty->assign('v_name', $versionName);
		$smarty->assign('v_text', $docText);
		$smarty->assign('others', array(
			array('images/mlee.jpg', 'winter 2010','by mlee 8h ago'), 
			array('images/dtran.jpg', 'winter 2010','by dtran 1d ago'),
			array('images/bella8.jpg', 'fall 2008', 'by bella8 2y ago')
			));
		
	}
	else {
	// temp..
	$smarty->assign('d_name', 'CS294 Class Notes');
	$smarty->assign('v_name', 'winter 2010');
	$smarty->assign('u_name', 'dtran');
	$smarty->assign('v_text', 'will we ever see this?');
	$smarty->assign('others', array(
		array('images/mlee.jpg', 'winter 2010','by mlee 8h ago'), 
		array('images/dtran.jpg', 'winter 2010','by dtran 1d ago'),
		array('images/bella8.jpg', 'fall 2008', 'by bella8 2y ago')
		));

}
$smarty->display('viewer.tpl');
}//end if user logged in
else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
