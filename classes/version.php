<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../db/db.php");
require_once(dirname(__FILE__) . "/repository.php");

class Version {
	
	private $userId;
	private $docId;
	private $description;
	private $lastSavedTime;
	
	private $commitId; //sha-1 hash
	private $repo;
	private $fileHandler;
	
	public function __construct($docId, $userId, $repo = 0,$description = 0) {
		$this->docId = $docId;	
		$this->userId = $userId;
		$this->description = $description;
		if($repo)
			$this->repo = $repo;
		else 
			$this->repo = new Repository($docId, $userId);
	}
	public static function CreateNewVersion($creator, $docId, $versionToClone = 0, $description = 0) {
		$repo = CreateNewRepository($docId, $userId, $versionToClone);
		if(!$repo) return false;
		$db = new DB();
		$params = array("docId" => $docId, "userId" => $userId, "repoPtr" => $repo->getLocation());
		mysqlEscapeArray($params);
		$newVersionQuery = "INSERT INTO Versions(doc_fk, u_fk, repo_ptr) " .
                        "VALUES('{$params["docId"]}', '{$params["userId"]}', '{$arr["repoPtr"]}')";

		$db->execQuery($newVersionQuery);
		return new Version($docId, $creator, $repo,$description);	
	}

	//returns array of Versions
	public function getVersionHistory() {
		
	}
	
	//just saves, update lastSavedTime
	public function save() {
		//fclose($fileHandler);
		//TODO: flesh out, merge with ckeditor	
	}
	
	//saves, does git commit, returns new Version object
	public function commit() {
		save();	
		$repo->commit();
		return this;
	}

	public function openVersionFile() {
		$fileHandler = $repo->getFile();
		return $fileHandler;
	}	
	
	public function diff($otherVersion) {
		return $repo->diff($otherVersion);
	}
	
	public function merge($otherVersion, $diffs) {
		//TODO:parse diffs, open other version, undo changes
		
		$repo->merge($otherVersion);
		commit();
		return true;
	}

	public function getRepoLocation(){
		return $repo->getLocation();
	}
}

?>
