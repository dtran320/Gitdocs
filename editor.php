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
	
	if (!$v_id) {
		$v_id = getVarClean("v_id");
	}
	if($v_id) { //opening an existing doc
		$version = new Version(0,0,0,0, $v_id);
		$versionName = $version->getName();
		$docText = $version->getDocFromDisk();
		
		$document = $version->getDocument();
		$smarty->assign('d_id', $document->docId);
		$smarty->assign('d_name', $document->name);
		$smarty->assign('v_name', $versionName);
		$smarty->assign('v_text', $docText);
			$smarty->assign('history', array(
				array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>{$versionName}</span>, which you saved 5m ago"),
				array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>{$document->name}</span> 5m ago"),

				));
			$smarty->assign('others', array(
				array('images/mlee.jpg', '<a class="v_name">winter 2010</a><br/>by mlee 8h ago', '1'),
				array('images/dtran.jpg', '<a class="v_name">winter 2010</a><br />by dtran 1d ago', '2'),
				array('images/bella8.jpg', '<a class="v_name">fall 2008</a><br />by bella8 2y ago', '3'),
				));
	
	}
	else {
	
		$action = postVarClean("action"); //"clone", "open", otherwise "new"
		$smarty->assign('action', $action);

	if ($action=="clone") {
		$documentId = postVarClean("document_id");
		$ownerId = postVarClean("owner_id");
		$description = postVarClean("description");
	
		$version = Version::CreateNewVersion($user->userId, $documentId, $ownerId, $description);
		$versionName = $version->getName();
		$docText = $version->getDocFromDisk();
		$document = $version->getDocument();
		$smarty->assign('d_id', $document->docId);
		$smarty->assign('d_name', $document->name);
		$smarty->assign('v_name', $versionName);
		$smarty->assign('v_text', $docText);
			$smarty->assign('history', array(
				array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>{$versionName}</span>, which you saved 5m ago"),
				array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>{$document->name}</span> 5m ago"),

				));
		$smarty->assign('others', array(
			array('images/mlee.jpg', '<a class="v_name">winter 2010</a><br/>by mlee 8h ago', '1'),
			array('images/dtran.jpg', '<a class="v_name">winter 2010</a><br />by dtran 1d ago', '2'),
			array('images/bella8.jpg', '<a class="v_name">fall 2008</a><br />by bella8 2y ago', '3'),
			));


	}//end if action is clone

	else { //action is new
		$document = Document::CreateNewDocument();
		$v_name = 'Untitled';
		$version = Version::CreateNewVersion($user->userId, $document->docId);
		$smarty->assign('d_id', $document->docId);

		$smarty->assign('d_name', $document->name);
		$smarty->assign('v_name', 'Untitled');

		$smarty->assign('v_text', '');
	
		// we should flesh out all the different phrases instead of doing this:
		$smarty->assign('history', array(
			array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>{$v_name}</span>, which has not been saved."),
			));
		$smarty->assign('others', array());
	
	}
} //end else

	$smarty->display('editor.tpl');

} // end if user logged in
else {
	$smarty->assign('signin_error', "You must sign up or login to create a version.");
	$smarty->display('signup.tpl');
}
?>
