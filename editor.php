<?
require_once('config.php');

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
	$smarty->assign('iconPtr', $user->iconPtr);
	
	$action = postVarClean("action"); //"clone", "open", otherwise "new"
	$smarty->assign('action', $action);

	if(($v_id = getVarClean("v_id")) || $action=="current") { //opening an existing doc
		if($v_id) 
			$version = new Version(0,0,0,0, $v_id);
		else {
			$document_id = postVarClean("document_id");
			$version = new Version($document_id, $user->userId);
		}
		if($version->getUserId() != $user->userId) {
			header('Location: viewer.php?v_id='. $version->versionId);
			exit(0);
		}
		$versionName = $version->getName();
		$docText = $version->getDocFromDisk();
		
		$document = $version->getDocument();
		$smarty->assign('d_id', $document->docId);
		$smarty->assign('v_id', $version->versionId);
		$smarty->assign('d_name', stripslashes($document->name));
		$smarty->assign('v_name', stripslashes($versionName));
		$smarty->assign('class_name', $document->getClassName()); 

		$smarty->assign('v_text', $docText);
		
		
	} else {

		if ($action=="clone") {
			$documentId = postVarClean("document_id");
			$versionToClone = postVarClean("clone_id");
			$description = postVarClean("description");
	
			$version = Version::getVersionForUser($documentId, $user->userId, $versionToClone, $description);

			$versionName = $version->getName();
			$docText = $version->getDocFromDisk();
			$document = $version->getDocument();
			$smarty->assign('d_id', $document->docId);
			$smarty->assign('d_name', $document->name);
			$smarty->assign('class_name', $document->getClassName());
			$smarty->assign('v_name', $versionName);
			$smarty->assign('v_text', $docText);
			$smarty->assign('history', getHistory($versionName, $document));

		}//end if action is clone

		else { //action is new
			$document = Document::CreateNewDocument();
			$v_name = 'Untitled';
			$version = Version::CreateNewVersion($document->docId, $user->userId);
			$smarty->assign('d_id', $document->docId);

			$smarty->assign('d_name', $document->name);
			$smarty->assign('v_name', 'Untitled');
			$smarty->assign('class_name', 'Unknown Course');

			$smarty->assign('v_text', '');
	
			// we should flesh out all the different phrases instead of doing this:
			$smarty->assign('history', array(
				array("left", $user->iconPtr,"you are now editing <span class='v_name'>{$v_name}</span>, which has not been saved."),
				));
		}
	} //end else
	
	//Set sidebar history
	$versionHistory = $version->getVersionHistory();
	$smarty->assign('history', $versionHistory);
	
	$all_classes = Document::getAllClasses();
	$smarty->assign('all_classes', $all_classes);
	$smarty->assign('others', getClassmates($document, $user));
	$smarty->display('editor.tpl');
} // end if user logged in
else {
	header('Location: signup.php');
}
?>
