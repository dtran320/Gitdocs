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
		foreach ($version_infos as $v_info) {
			$author_name = $v_info['display_name'];
			$v_id = $v_info['v_id'];
			$version = new Version(0,0,0,0, $v_id);
			$author_id = $version->getUserId();
			if($author_id == $user->userId) {
				$userHasDoc = true;
			}
			$v_text = $version->getDocFromDisk();
			$v_name = $version->getName();
			$versions[] = array('author_name'=> $author_name, 'v_name'=> $v_name, 'v_text' =>$v_text, 'v_id' => $v_id, 'author_id'=>$author_id, 'iconPtr'=>getIconPtr($author_id));
		}
		$d_info = Document::getDocInfoForId($d_id);
		$smarty->assign('d_name', $d_info['name']);
		$smarty->assign('versions', $versions);

		$smarty->assign('d_id', $d_id);
		$smarty->assign('userHasDoc', $userHasDoc);
		$smarty->display('viewall.tpl');
	} else {
	}
}
else {
	header('Location: signup.php');
}
?>
