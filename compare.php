<?
session_start();
require('init_smarty.php');
require('lib/simplediff.php');
require('classes/user.php');
require('classes/diff.php');

include_once "lib/Diff/Diff.php";
include_once "lib/Diff/Diff/Renderer.php";
include_once "lib/Diff/Diff/Renderer/inline.php";

if($user = User::getLoggedInUser()) {

	$smarty->assign('logged_in_user', $user->getUserInfo());
	$doc = Document::getDocInfoForId($d_id);
	$version = new Version($d_id, $u_id);
	$other_version = new Version($d_id, $other_u_id);

	$smarty->assign('d_id', $d_id)	;
	$smarty->assign('u_id', $u_id);
	$smarty->assign('other_u_id', $other_u_id);
	$smarty->assign('d_name', $doc['name']);
	$smarty->assign('v_name', $version->getDescription());
	$smarty->assign('other_u_name', $other_user['username']);
	$smarty->assign('other_v_name', $other_version->getDescription());

	// we should flesh out all the different phrases instead of doing this:
	$smarty->assign(history, array(
		array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>winter 2010</span>, which you saved 5m ago"),
		array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>winter 2010</span> 5m ago"),

		));
	$smarty->assign(others, array(
		array('images/mlee.jpg', '<a class="v_name">winter 2010</a><br/>by mlee 8h ago'),
		array('images/dtran.jpg', '<a class="v_name">winter 2010</a><br />by dtran 1d ago'),
		array('images/bella8.jpg', '<a class="v_name">fall 2008</a><br />by bella8 2y ago'),
		));

//	$patch = implode("\n", $version->diff($other_version));
	$patch = file_get_contents('tests/example.patch');
	$diff = new Text_Diff('string', array($patch));
	$renderer = new Text_Diff_Renderer_inline();
	$out = $renderer->render($diff);

} else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
