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
require_once('sidebar.php');

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
		$smarty->assign('others', getClassmates($document, $user));
		
	}
	$smarty->display('viewer.tpl');
}//end if user logged in
else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
