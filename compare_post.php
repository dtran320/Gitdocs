<?

require('classes/diff.php');

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
//$myVersion = new Version(
/*foreach ($diffs as $diff) {
	echo $diff->userAction . ' ' . $diff->type . ' ' . $diff->index . '<br/>';
}*/


?>
