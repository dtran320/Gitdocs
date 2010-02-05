<?
include_once"compare.php";

$patch = file_get_contents('tests/example.patch');
$diff = new Text_Diff('string', array($patch));
$renderer = new Text_Diff_Renderer_inline();
$out = $renderer->render($diff);

$out = '<span class="likedislike"><span class="likeall" onclick="likeAll_inline();">L</span> | <span class="dislikeall" onclick="dislikeAll_inline();">D</span> |<span class="undoall" onclick="undoAll_inline();">U</span></span>' . $out;

$out = str_replace("<ins>", "<div class='inline_change'><ins>", $out);
$out = str_replace("</ins>", "</ins></div><div class='inline_ld'></div>", $out);
$out = str_replace("<del>", "<div class='inline_change'><del>", $out);
$out = str_replace("</del>", "</del></div><div class='inline_ld'></div>", $out);
$out = str_replace("</del></div><div class='inline_ld'></div>\n<div class='inline_change'><ins>", "</del><ins>", $out);

$smarty->assign('diff', $out);

$smarty->display('compare_inline.tpl');


?>
