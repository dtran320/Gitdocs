<?
session_start();
require('init_smarty.php');
require('lib/simplediff.php');
require('classes/diff.php');
include_once "lib/Diff/Diff.php";
include_once "lib/Diff/Diff/Renderer.php";
include_once "lib/Diff/Diff/Renderer/inline.php";

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

$patch = file_get_contents('tests/example.patch');
$diff = new Text_Diff('string', array($patch));
$renderer = new Text_Diff_Renderer_inline();
$out = $renderer->render($diff);

$out = str_replace("<ins>", "<div style='float: right; width: 300px; clear: both;' class='inline_change'><ins>", $out);
$out = str_replace("</ins>", "</ins></div><div class='inline_ld'></div>", $out);
$out = str_replace("<del>", "<div style='float: left; width: 300px; clear: left;' class='inline_change'><del>", $out);
$out = str_replace("</del>", "</del></div><div class='inline_ld'></div>", $out);
$out = str_replace("<same>", "<div style='float: left; width: 300px; clear: both;'><same>", $out);
$out = str_replace("</same>", "</same></div>", $out);

$out = str_replace("</del></div><div class='inline_ld'></div>\n<div style='float: right; width: 300px; clear: both;' class='inline_change'><ins>", 
	"</del></div>\n<div style='float: right; width: 300px;' class='mod'><ins>", $out);	

// this is copied from http://svn.kd2.org/svn/misc/libs/diff/
// breaks down the separation between logic and view but that's okay for now

$smarty->assign('diff', $out);
$smarty->display('compare.tpl');
?>
