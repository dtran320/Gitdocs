<?
include_once "compare.php";

// output of git diff instead of reading patch from file!!
$patch = file_get_contents('tests/example.patch');
$diff = new Text_Diff('string', array($patch));
$renderer = new Text_Diff_Renderer_inline();
$out = $renderer->render($diff);

// cheating with the separation between logic and display, but whatevs for now
$out = str_replace("<ins>", "<div style='float: right; width: 300px; clear: both;' class='inline_change'><ins>", $out);
$out = str_replace("</ins>", "</ins></div><div class='inline_ld'></div>", $out);
$out = str_replace("<del>", "<div style='float: left; width: 300px; clear: left;' class='inline_change'><del>", $out);
$out = str_replace("</del>", "</del></div><div class='inline_ld'></div>", $out);
$out = str_replace("<same>", "<div style='float: left; width: 300px; clear: both;'><same>", $out);
$out = str_replace("</same>", "</same></div>", $out);

$out = str_replace("</del></div><div class='inline_ld'></div>\n<div style='float: right; width: 300px; clear: both;' class='inline_change'><ins>", 
	"</del></div>\n<div style='float: right; width: 300px;' class='mod'><ins>", $out);	

$smarty->assign('diff', $out);
$smarty->display('compare.tpl');

?>
