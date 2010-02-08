<?php

require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../classes/version.php");

function testCreateVersion($docId = 1) {
	echo "Creating version";
	$version = Version::createNewVersion("1",$docId);

		if($version)
			echo "Created new version for dtran320 of $docId \n";
		else {
			echo "Failed.<br/>";
			return false;
		}
	
	$unused = $version->openVersionFile();
 	fclose($unused);		
	$version->commit();
	$version2 = Version::createNewVersion("2",$docId,$version);	
	$unused = $version2->openVersionFile();
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
