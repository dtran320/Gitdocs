<?
session_start();
require('init_smarty.php');
require('lib/simplediff.php');
require('classes/user.php');
require('classes/diff.php');
require_once("sidebar.php");

include_once "lib/Diff/Diff.php";
include_once "lib/Diff/Diff/Renderer.php";
include_once "lib/Diff/Diff/Renderer/inline.php";

if($user = User::getLoggedInUser()) {

	$smarty->assign('logged_in_user', $user->getUserInfo());

	$version = new Version($d_id, $u_id);
	$document = $version->getDocument();
	$other_version = new Version($d_id, $other_u_id);
	$other_user = User::getUserInfoForId($other_u_id);

	$smarty->assign('history', getHistory($version->getName(), $document));
	$smarty->assign('others', getClassmates($user, $document));
	$smarty->assign('v_id', $version->getVersionId());
	$smarty->assign('other_v_id', $other_version->getVersionId());
	$smarty->assign('d_id', $d_id)	;
	$smarty->assign('u_id', $u_id);
	$smarty->assign('other_u_id', $other_u_id);
	$smarty->assign('d_name', $doc['name']);
	$smarty->assign('v_name', $version->getName());
	$smarty->assign('other_u_name', $other_user['username']);
	$smarty->assign('other_v_name', $other_version->getName());

	$diff_array = insertSameTags($version->diff($other_version));
	$patch = implode("\n", $diff_array);
//$patch = file_get_contents('tests/example.patch');
	$diff = new Text_Diff('string', array($patch));
	$renderer = new Text_Diff_Renderer_inline();
	$out = $renderer->render($diff);

} else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}

function insertSameTags($diff_lines) {
	// first 4 lines are just the header
	// looks funky, but has to do with the format that the diff lib expects
	$out_same = 1;
	for($i = 3; $i < sizeof($diff_lines); $i++) {
		$line = $diff_lines[$i];
			$type = substr($line, 0, 1);
			if ($type != "+" && $type != "-") {	
				if ($out_same) {
					$out_same = 0;
					$diff_lines[$i] = " <same>" . $line;
				}
			} else {
				if(!$out_same) {
					$out_same = 1;
					$diff_lines[$i - 1] = $diff_lines[$i - 1]."</same>";
				}
			}
	}
	if (!$out_same) {
		$diff_lines[$i-1] = $diff_lines[$i - 1]."</same>";
	}
	return $diff_lines;
}
?>
