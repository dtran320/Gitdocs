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
	
// temp..
$smarty->assign('d_name', 'CS294 Class Notes');
$smarty->assign('v_name', 'winter 2010');
$smarty->assign('u_name', 'mlinsey');
$smarty->assign('other_u_name', 'mlee');
$smarty->assign('other_v_name', 'winter 2010');

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
} else {
	$smarty->assign('signin_error', "You must sign up or login to do that.");
	$smarty->display('signup.tpl');
}
?>
