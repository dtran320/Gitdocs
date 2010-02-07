<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/version.php");
require_once(dirname(__FILE__) . "/../classes/diff.php");

function testDiff() {
	echo "diffing version";
	$version = new Version(1,1);
	$version2 = new Version(1,2);
	$diffResult = $version->diff($version2);
	echo "diff result:\n";
	Print_r($diffResult);
	echo "generating diff objects\n";

}

?>
