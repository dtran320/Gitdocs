<?
$d_id = $_POST['d_id'];
$u_id =  $_POST['u_id'];
$other_u_id = $_POST['other_u_id'];

include_once"compare.php";

$out = '<span class="likedislike"><span class="likeall" onclick="likeAll_inline();">L</span> | <span class="dislikeall" onclick="dislikeAll_inline();">D</span> |<span class="undoall" onclick="undoAll_inline();">U</span></span>' . $out;

$like_links = "<div class='inline_ld'></div>";
$ins_open = "<span class='inline_change ins'><ins>";
$ins_close = "</ins></span>" . $like_links;
$del_open = "<span class='inline_change del'><del>";
$del_close = "</del></span>" . $like_links;

$out = str_replace("<ins>", $ins_open, $out);
$out = str_replace("</ins>", $ins_close, $out);
$out = str_replace("<del>", $del_open, $out);
$out = str_replace("</del>", $del_close, $out);
//$out = str_replace("</del></div><div class='inline_ld'></div>\n<div class='inline_change'><ins>", "</del><ins>", $out);

$smarty->assign('diff', $out);

$smarty->display('compare_inline.tpl');


?>
