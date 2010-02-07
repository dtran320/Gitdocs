<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../db/db.php");
require_once(dirname(__FILE__) . "/repository.php");
require_once('document.php');

class Version {
	
	private $userId;
	private $docId;
	private $description;
	private $lastSavedTime;
	
	private $commitId; //sha-1 hash
	private $repo;
	
	public $textCache;
	public $fileHandler;
	
	public function __construct($docId, $userId, $repo = 0,$description = 0) {
		global $DOCUMENTS_PATH;
		$location = "$DOCUMENTS_PATH$docId/$userId";
		$this->docId = $docId;	
		$this->userId = $userId;
		$this->description = $description;
		if($repo)
			$this->repo = $repo;
		else 
			$this->repo = new Repository($location);
		$this->textCache = "";
		$this->fileHandler = fopen("$location/document.html",'r+');
	}
	
	public function __destruct() {
		fclose($this->fileHandler);
	}
	public static function CreateNewVersion($userId, $docId, $versionToClone = 0, $description = 0) {
		$repo = Repository::CreateNewRepository($docId, $userId, $versionToClone);
		if(!$repo) return false;
		$db = new DB();
		$params = array("docId" => $docId, "userId" => $userId, "repoPtr" => $repo->getLocation());
		mysqlEscapeArray($params);
		$newVersionQuery = "INSERT INTO Versions(doc_fk, u_fk, repo_ptr) " .
                        "VALUES('{$params["docId"]}', '{$params["userId"]}', '{$params["repoPtr"]}')";
		$db->execQuery($newVersionQuery);
		return new Version($docId, $userId, $repo,$description);	
	}

	//returns array of Versions
	public function getVersionHistory() {
		
	}
	
	//just saves, update lastSavedTime
	public function save($text) {
		$this->textCache = $text;
		$this->updateTimestamp();
		return fwrite($this->fileHandler, $text);
		//fclose($fileHandler);
		//TODO: flesh out, merge with ckeditor	
		
	}
	
	//saves, does git commit, returns new Version object
	public function commit() {
		$this->save();	
		$this->repo->commit();
		return $this;
	}

	public function openVersionFile($branch = 0) {
		$fileHandler = $this->repo->getFile($branch);
		return $fileHandler;
	}	
	
	public function readFileToArray($branch = 0) {
		return $this->repo->readFileToArray($branch);
	}
	
	public function diff($otherVersion) {
		return $this->repo->diff($this, $otherVersion);
	}
	
	public function merge($otherVersion, &$diffs) {
		//TODO:parse diffs, open other version, undo changes
		
		$repo->merge($this, $otherVersion, $diffs);
		commit();
		return true;
	}

	public function getRepoLocation(){
		return $this->repo->getLocation();
	}
	
	public function getDescription() {
		return $this->description;
	}
	public function getUserId(){
		return $this->userId;
	}
	public function getDocId(){
		return $this->docId;
	}
	
	public function getDocument() {
		$db = new DB();
		$getDocQuery = "SELECT doc_id, name FROM Documents WHERE doc_id='{$this->docId}'";
		$db->execQuery($getDocQuery);
		$row = $db->getNextRow();
		if($row) return new Document($row['doc_id'], $row['name']);
		else return false;
	}
	
	public function updateTimestamp($time=0) {
		if(!$time) $time = time();
		$db = new DB();
		$updateTimeQuery = "UPDATE Versions SET last_saved_time='$time' WHERE doc_fk='{$this->docId}' AND u_fk='{$this->userId}'";
		return $db->execQuery($updateTimeQuery);
	}
	
	public function getName() {
		$db = new DB();
		$selectQuery = "select v_name FROM Versions WHERE doc_fk='{$this->docId}' AND u_fk='{$this->userId}'";
		$db->execQuery($renameQuery);
		$row = $db->getNextRow();
		return $row["v_name"];
	}
	
	public function getDocument() {
		return fread($this->fileHandler, 8192);
	}
	
	public function rename($newName) {
		$db = new DB();
		$newName = mysql_real_escape_string($newName);
		$renameQuery = "UPDATE Versions SET v_name = '$newName' WHERE doc_fk='{$this->docId}' AND u_fk='{$this->userId}'";
		return $db->execQuery($renameQuery);
	}
	
	//get n most recent versions for User, everything if n =0
	//assume userId is sanitized (passed from User class)
	public static function getRecentVersionsForUser($userId, $n=0) {
		$db = new DB();
		$versions = array();
		$selectQuery = "SELECT doc_id as dId, name as dName, v_name as vName, v_id as vId, last_saved_time as timestamp " .
			"FROM Versions INNER JOIN Documents " . 
			"ON Versions.doc_fk = Documents.doc_id " .
			"INNER JOIN Users " .
			"ON Versions.u_fk = Users.u_id " .
			"WHERE u_id = '$userId' ORDER BY last_saved_time DESC";
		if($n > 0) $selectQuery .= " LIMIT 0, $n";
		$db->execQuery($selectQuery);
		while($row = $db->getNextRow()) {
			$row['timestamp'] = getLocalTime($row['timestamp']);
			$versions[] = $row;
		}
		return $versions;
	}
}


?>
