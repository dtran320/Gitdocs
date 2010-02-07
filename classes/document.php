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
	public $name, $docId;
	
	//Creates a new document, creates file structure on disk, create in DB
	public static function CreateNewDocument($name = "New Document") {
		global $DOCUMENTS_PATH;
		//insert into database
		$db = new DB();
	        $newDocQuery = sprintf("INSERT INTO Documents (name) VALUES('".
					mysql_real_escape_string($name) ."');");	
		$db->execQuery($newDocQuery);	
		$newDocID = $db->getInsertedID();
		if(!$newDocID) return false;
		if(!mkdir("$DOCUMENTS_PATH$newDocID", 0700)) return false;
		
		$document = new Document($newDocID, $name);
		return $document;
	}
	
	public static function getDocInfoForId($id) {
		$db = new DB();
		$id = mysql_real_escape_string($id);
		$docInfoQuery = "SELECT name FROM Documents " .
			"WHERE doc_id='{$id}'";
		var_dump($docInfoQuery);
		$db->execQuery($docInfoQuery);
		$row = $db->getNextRow();
		return $row;
	}

	public function __construct($docId, $name = 0 ){
		$this->docId = $docId;
		$this->name = $name;
	} 
	
	public function rename($newName) {
		//verify that the logged in user owns this doc later?
		$db = new DB();
		$newName = mysql_real_escape_string($newName);
		$renameQuery = "UPDATE Documents SET name = '$newName' WHERE doc_id='{$this->docId}'";
		return $db->execQuery($renameQuery);
	}
	
}

?>
