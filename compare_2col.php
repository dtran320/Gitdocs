<?
$d_id = $_POST['d_id'];
$u_id =  $_POST['u_id'];
$other_u_id = $_POST['other_u_id'];

include_once "compare.php";

// cheating with the separation between logic and display, but whatevs for now
$like_links = "<div class='inline_ld'></div>";

$ins_open = "<div class='inline_change ins'><ins>";
$ins_close = "</ins></div>" . $like_links;
$del_open = "<div class='inline_change del'><del>";
$del_close = "</del></div>" . $like_links;
$same_open = "<div style='float: left; width: 300px; clear: both;'><same>";
$same_close = "</same></div>";


$out = str_replace("<ins>", $ins_open, $out);
$out = str_replace("</ins>", $ins_close, $out);
$out = str_replace("<del>", $del_open, $out);
$out = str_replace("</del>", $del_close, $out);
$out = str_replace("<same>", $same_open, $out);
$out = str_replace("</same>", $same_close, $out);

$out = str_replace($del_close . "\n" . $ins_open,	"</del></div><div  class='mod ins'><ins>", $out);	

$smarty->assign('diff', $out);
$smarty->display('compare.tpl');

?>
