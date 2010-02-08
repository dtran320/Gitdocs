<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/version.php");
require_once(dirname(__FILE__) . "/../classes/diff.php");

function testMerge() {
	$docId = testCreateDocument();
	testCreateVersion($docId, $version, $version2);
			
	//testDiff($docId);
	//$version->diff($version2);
	
	//$version->merge
		
}

?>
