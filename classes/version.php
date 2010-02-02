<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

class Version {
	
	private $userId;
	private $docId;
	private $description;
	private $lastSavedTime;
	
	private $commitId; //sha-1 hash

	private $fileHandler;
	
	public function __construct($docId, $userId, $description = 0) {
		$this->docId = $docId;	
		$this->userId = $userId;
		$this->description = $description;
	}
	public static function CreateNewVersion($creator, $docId, $versionToClone, $description = 0) {
	
	}

	//returns array of Versions
	public function getVersionHistory() {
		
	}
	
	//just saves, update lastSavedTime
	public function save() {
		
	}
	
	//saves, does git commit, returns new Version object
	public function commit() {
		
	}
	
	/* Private instance methods */
	private function openVersionFileFromDisk() {
		
	}
	
}

?>
