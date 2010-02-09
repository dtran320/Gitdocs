<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/version.php");
require_once(dirname(__FILE__) . "/../classes/diff.php");

function testMerge() {
	$doc = testCreateDocument();
	
	$docId = $doc->docId; 
	testCreateVersion($docId, $version, $version2);
			
	//testDiff($docId);
	$version->diff($version2);
	$diff1 = new Diff($docId,1,2,UserDiffAction::accepted, DiffType::mod,0);
	$diff2 = new Diff($docId,1,2,UserDiffAction::rejected, DiffType::mod,1);
	$diffArray = array($diff1, $diff2);
	$version->merge($version2, $diffArray);		
	
	$versions = $doc->getAllVersions();
	print_r($versions);
}

?>
