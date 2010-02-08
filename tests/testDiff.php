<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/version.php");
require_once(dirname(__FILE__) . "/../classes/diff.php");

function testDiff($docId = 1) {
	echo "diffing version";
	$version = new Version($docId,1);
	$version2 = new Version($docId,2);
	$diffResult = $version->diff($version2);
	echo "diff result:\n";
	Print_r($diffResult);
	echo "generating diff objects\n";

}

?>
