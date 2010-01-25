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
	
	public function __construct() {
		
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