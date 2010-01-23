<?php

/* ----------------------------------------------------------------------------
 * Document class
 * Object-relational class for the documents 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
class Document {
	
	//attributes
	private $name;
	private $docId;
	
	//Creates a new document, creates file structure on disk, create in DB
	public static function CreateNewDocument($creator, $name = 0) {
		//create directory structure on disk
		//insert into database
		//set docID as returned from database
		//return Document instance
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