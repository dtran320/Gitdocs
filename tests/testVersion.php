<?php

require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../classes/version.php");

function testCreateVersion($docId = 1, &$version, &$version2) {
	echo "Creating version";
	$version = Version::CreateNewVersion("1",$docId);

		if($version)
			echo "Created new version for dtran320 of $docId \n";
		else {
			echo "Failed.<br/>";
			return false;
		}
	echo "writing to document\n";
	$unused = $version->openVersionFile();
	fwrite($unused, "this is a line in the initial version, before branching\n");
 	fclose($unused);		
	$version->commit();

 	echo "creating versoin for user ID#2...";	
	$version2 = Version::CreateNewVersion("2",$docId,$version->getVersionId());	
	if($version2) {
		echo "succeeded.\n";
	}else{
		echo "failed!\n";
	}
	$unused = $version2->openVersionFile();
	
	fwrite($unused, "this is a line in the initial version, before branching\n");

	fwrite($unused, "this is a new line in the branched version\n");
	fclose($unused);
	$version2->commit();
	$v2arr = $version2->readFileToArray();
	//$v2arr[0]
	$diffResult = $version->diff($version2);
	echo "diff result:\n";
	Print_r($diffResult);
}

function testGetRecentVersionsForUser() {	
	$v = Version::getRecentVersionsForUser(23);
	var_dump($v);
}

?>
