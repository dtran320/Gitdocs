<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/Version.php");

function testCreateVersion() {
	echo "Creating version";
	$version = Version::createNewVersion("1","1");

		if($version)
			echo "Created new version for dtran320 of doc 1\n";
		else {
			echo "Failed.<br/>";
			return false;
		}
/*	
	$unused = $version->openVersionFile();
 	fclose($unused);		
	$version->commit();
	$version2 = Version::createNewVersion("2","1",$version);	
	$unused = $version2->openVersionFile();
	fclose($unused);
	$version->commit();
	$v2arr = $version2->readFileToArray();
	//$v2arr[0]
	$diffResult = $version->diff($version2);
	echo "diff result:\n";
	Print_r($diffResult);
*/	

}

?>
