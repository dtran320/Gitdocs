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

	$d_id = getVarClean('d_id');
	if($d_id) {
		$document = new Document($d_id);
		$version_infos = $document->getAllVersions();
		$versions = array();
		$userHasDoc = false;
		foreach ($version_infos as $key => $v_info) {
			$author_name = $v_info['display_name'];
			$v_id = $v_info['v_id'];
			$version = new Version(0,0,0,0, $v_id);
			$author_id = $version->getUserId();
			$v_text = $version->getDocFromDisk();
			$v_name = $version->getName();
			$versions[] = array('author_name'=> $author_name, 'v_name'=> $v_name, 'v_text' =>$v_text, 'v_id' => $v_id, 'author_id'=>$author_id, 'iconPtr'=>getIconPtr($author_id));

			if($author_id == $user->userId) {
				$userHasDoc = true;
				// swap so that own version is first.
				$temp = $versions[0];
				$versions[0] = $versions[$key];
				$versions[$key] = $temp;
			}
		}

		$d_info = Document::getDocInfoForId($d_id);
		$smarty->assign('d_name', $d_info['name']);
		$smarty->assign('type', $d_info['type']);
		$smarty->assign('date', $d_info['lecture_date']);
		$smarty->assign('class_name', $d_info['class_name']);

		$smarty->assign('versions', $versions);
		$smarty->assign('d_id', $d_id);
		$smarty->assign('userHasDoc', $userHasDoc);
		$smarty->display('viewall.tpl');
	} else {
	}
}
else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
