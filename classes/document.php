<?php

/* ----------------------------------------------------------------------------
 * Document class
 * Object-relational class for the documents 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../db/db.php");

class Document {
	
	//attributes
	private $name;
	private $docId;
	
	//Creates a new document, creates file structure on disk, create in DB
	public static function CreateNewDocument($creator, $name = "New Document") {
		global $DOCUMENTS_PATH;
		//insert into database
		$db = new DB();
	        $newDocQuery = sprintf("INSERT INTO Documents (name) VALUES('".
					mysql_real_escape_string($name) ."');");	
		$db->execQuery($newDocQuery);	
		$newDocID = $db->getInsertedID();
		if(!$newDocID) return false;
		if(!mkdir($DOCUMENTS_PATH . "/" . $newDocID, 0600)) return false;
		
		$document = new Document($newDocID, $name);
		return $document;
	}
	
	public function __construct($docId, $name = 0 ){
		$this->docId = $docId;
		$this->name = $name;
	}
	
	public function name() {
		return $this->name;
	}
	
	public function setName($newName) {
		$this->name = $newName;
	}
	
}

?>
