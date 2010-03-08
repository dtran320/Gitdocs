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
	$smarty->assign('displayName', $user->displayName);
	
	$v_id = getVarClean("v_id");
	if($v_id) { //opening an existing doc
		$r_id = getVarClean("r_id");
		$branch = $r_id? $r_id : "master";
		$version = new Version(0,0,0,0, $v_id, $branch);

		//if this is a current version that belongs to the user, go to editor
		if (!$r_id && $version->getUserId() == $user->userId) {	
			header('Location: editor.php?v_id='.$v_id);
			exit(0);	
		}

		$author_info = User::getUserInfoForId($version->getUserId());
		$smarty->assign('author_name', $author_info['displayName']);
		$versionName = $version->getName();
		$docText = $version->getDocFromDisk();
		$document = $version->getDocument();

		$smarty->assign('d_id', $document->docId);
		$smarty->assign('d_name', $document->name);
		$smarty->assign('v_id', $v_id);
		$smarty->assign('v_name', $versionName);
		$smarty->assign('v_text', $docText);
		$smarty->assign('others', getClassmates($document, $user));
		
		//
		if($r_id) {
			$smarty->assign('timestamp', $version->getVersionSaveTime());
			$submit_text = "Return to current version";
			$action = "current";
		}
		else if(Version::doesUserHaveVersion($document->docId, $user->userId)) {
			$submit_text = "Go to my version";
			$action = "current";
		}
		else {
			$submit_text = "Start working off this version";
			$action = "clone";
		}

		$smarty->assign('action', $action);
		$smarty->assign('submit_text', $submit_text);
	}
	$smarty->display('viewer.tpl');
}//end if user logged in
else {
	header('Location: signup.php');
}
?>
