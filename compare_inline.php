<?
$d_id = $_POST['d_id'];
$u_id =  $_POST['u_id'];
$other_u_id = $_POST['other_u_id'];

include_once"compare.php";

$out = '<span class="likedislike"><span class="likeall" onclick="likeAll_inline();">L</span> | <span class="dislikeall" onclick="dislikeAll_inline();">D</span> |<span class="undoall" onclick="undoAll_inline();">U</span></span>' . $out;

$out = str_replace("<ins>", "<div class='inline_change'><ins>", $out);
$out = str_replace("</ins>", "</ins></div><div class='inline_ld'></div>", $out);
$out = str_replace("<del>", "<div class='inline_change'><del>", $out);
$out = str_replace("</del>", "</del></div><div class='inline_ld'></div>", $out);
$out = str_replace("</del></div><div class='inline_ld'></div>\n<div class='inline_change'><ins>", "</del><ins>", $out);

$smarty->assign('diff', $out);

$smarty->display('compare_inline.tpl');


?>
