<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/Version.php");

function testCreateVersion() {
	echo "Creating version";
	$version = Version::createNewVersion("dtran320","1");

		if($version)
			echo "Created new version for dtran320 of doc 1<br>";
		else {
			echo "Failed.<br/>";
			return false;
		}
	
	
	echo "<br/>";

}

?>
