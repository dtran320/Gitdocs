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
		foreach ($version_infos as $v_info) {
			$author_name = $v_info['display_name'];
			$icon_ptr = $v_info['icon_ptr'] ? $v_info['icon_ptr'] : 'images/default.jpg';
			$v_id = $v_info['v_id'];
			$version = new Version(0,0,0,0, $v_id);
			$v_text = $version->getDocFromDisk();
			$v_name = $version->getName();
			$versions[] = array($author_name, $icon_ptr, $v_name, $v_text);
		}
		$smarty->assign('author_names', 'needs to be an array');
		$smarty->assign('v_names', 'needs to be an array?');
		$smarty->assign('d_name', 'dname placeholder');
		$smarty->assign('versions', $versions);

		$smarty->display('viewall.tpl');
	} else {
	}
}
else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
