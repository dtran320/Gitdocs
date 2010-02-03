<?

require('classes/diff.php');

$i = 0;
$reported_i = 0;
$diffs = array();

if (!isset($_POST['hidden0'])) {
	$i = $i + 1;
}
while (isset($_POST['hidden' . $i])) {
	if ($_POST['hidden' . $i] == "like") 
		$user_action = UserDiffAction::accepted;
	else
		$user_action = UserDiffAction::rejected;

	if ($_POST['type' . $i] == "change") {
		$type = DiffType::del;
		$diff = new Diff("doc_id", "user", "other_user", $user_action, $type, $reported_i);
		$diffs[] = $diff;
		$type = DiffType::ins;
		$reported_i = $reported_i+1;
		$diff = new Diff("doc_id", "user", "other_user", $user_action, $type, $reported_i);
		$diffs[] = $diff;
	} else if ($_POST['type' . $i] == "del"){

		$type = DiffType::del;
		$diffs[] = new Diff("doc_id", "user", "other_user", $user_action, $type, $reported_i);
	} else {
		$type = DiffType::ins;
		$diffs[] = new Diff("doc_id", "user", "other_user", $user_action, $type, $reported_i);
	}
	$reported_i = $reported_i + 1;
	$i = $i + 1;;
}

// so at this point i have an array of Diff objects, here you go marky mark.

foreach ($diffs as $diff) {
	echo $diff->userAction . ' ' . $diff->type . ' ' . $diff->index . '<br/>';
}


?>
