<?

require_once('lib/utils.php');
require_once('classes/diff.php');
require_once('classes/version.php');

$v_id = postVarClean("v_id");
$other_v_id = postVarClean("other_v_id");

echo "v_id: " . $v_id . "<br/>";
echo "other_v_id" . $other_v_id . "<br/>";
$i = 0;
$diffs = array();

while (isset($_POST['hidden' . $i])) {
	if ($_POST['hidden' . $i] == "like") 
		$user_action = UserDiffAction::accepted;
	else
		$user_action = UserDiffAction::rejected;

	if ($_POST['type' . $i] == "change") {
		$type = DiffType::mod;
	} else if ($_POST['type' . $i] == "del"){
		$type = DiffType::del;
	} else {
		$type = DiffType::ins;
	}
	$diffs[] = new Diff("doc_id", "user", "other_user", $user_action, $type, $i);
	$i = $i + 1;;
}

// so at this point i have an array of Diff objects, here you go marky mark.
$myVersion = new Version(0,0,0,0,$v_id);
$otherVersion = new Version(0,0,0,0,$other_v_id);
$myVersion->merge($otherVersion, $diffs);
$_GET['v_id']=$v_id;
include('editor.php');
//foreach ($diffs as $diff) {
//	echo $diff->userAction . ' ' . $diff->type . ' ' . $diff->index . '<br/>';
//}


?>
