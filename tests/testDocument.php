<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/document.php");

function testCreateDocument() {
	echo "Creating Document testdoc";
	$document = Document::createNewDocument("testdoc");
		if($document)
			echo "Created new document testdoc <br>";
		else {
			echo "Failed.<br/>";
			return false;
		}
	
	echo "Testing that document name is correct...";
	echo ($document->name == "testdoc")? "Yes!" : "No!";
	
	echo "<br/>";
	return($document->docId);

}

?>
