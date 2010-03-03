<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../db/db.php');
require_once(dirname(__FILE__) . '/repository.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once('document.php');
require_once('searchEngine.php');

class Version {
	
	private $userId, $docId;
	private $description;
	public $lastSavedTime;
	public $versionId;
	private $commitId; //sha-1 hash
	private $repo;
	private $location;
	public $textCache;
	public $fileHandler;
	private $branch;
	
	public function __construct($docId=0, $userId=0, $repo = 0,$description = 0, $v_id = 0, $branch = 0) {
		global $DOCUMENTS_PATH;
		$db = new DB();	
		if($v_id) {
			$this->versionId = $v_id;
			$v_id = mysql_real_escape_string($v_id);
			$selectQuery = "SELECT doc_fk, u_fk FROM Versions WHERE v_id='{$v_id}'";
			$db->execQuery($selectQuery);
			$row = $db->getNextRow();
			if($row) {
				$docId = $row['doc_fk'];
				$userId = $row['u_fk'];
			}
		}
		else {
			$docIdSafe = mysql_real_escape_string($docId);
			$userIdSafe = mysql_real_escape_string($userId);
			$getVersionId = "SELECT v_id FROM Versions WHERE doc_fk='{$docIdSafe}' AND u_fk='{$userIdSafe}'";
			$db->execQuery($getVersionId);
			$row = $db->getNextRow();
			if($row)
				$this->versionId = $row["v_id"];
		}
		$this->location = "$DOCUMENTS_PATH$docId/$userId";
		$this->docId = $docId;	
		$this->userId = $userId;
		$this->description = $description;
		if($repo)
			$this->repo = $repo;
		else 
			$this->repo = new Repository($this->location);

		$this->textCache = "";
		//$this->fileHandler = fopen("$location/document.html",'r+');
		$this->branch = $branch? $branch : "master";
		$this->fileHandler = $this->repo->getFile($this->branch);

	}
	
	public function __destruct() {
		fclose($this->fileHandler);
	}
	
	public static function CreateNewVersion($docId, $userId, $versionToClone = 0, $description = 0) {
		$repo = Repository::CreateNewRepository($docId, $userId, $versionToClone);
		if(!$repo) return false;
		$db = new DB();
		$params = array("docId" => $docId, "userId" => $userId, "repoPtr" => $repo->getLocation());
		mysqlEscapeArray($params);
		$time = time();
		$newVersionQuery = "INSERT INTO Versions(doc_fk, u_fk, repo_ptr, last_saved_time) " .
                        "VALUES('{$params["docId"]}', '{$params["userId"]}', '{$params["repoPtr"]}', '{$time}')";
		if(DEBUG) echo $newVersionQuery;
		$db->execQuery($newVersionQuery);
		return new Version($docId, $userId, $repo,$description);	
	}

	//returns array of Versions
	public function getVersionHistory() {
		$command = "cd {$this->location}; git log --pretty=format:'%H %ct'";
		$output = runCommand($command);
		$revision = count($output);
		$revisions = array();
		foreach($output as $k => $version) {
			$revisions[$k]['revision'] = "Revision " . $revision;
			$versionArr = explode(" ", $version);
			$revisions[$k]['hash'] = $versionArr[0];
			$revisions[$k]['time'] = getLocalTime($versionArr[1]);
			$revision--;
		}
		return $revisions;
	}
	
	public function getVersionSaveTime() {
		$command = "cd {$this->location}; git log {$this->branch} -1 --pretty=format:'%ct'";
		$output = runCommand($command);
		return getLocalTime($output[0]);
	}
	
	//just saves, update lastSavedTime
	public function save($text) {
		$this->textCache = $text;
		$this->updateTimestamp();
		//if($text==0) return true;
		$this->repo->AcquireLock();
		$this->repo->checkout("master");
		rewind($this->fileHandler);
		$result = (fwrite($this->fileHandler, $text) && ftruncate($this->fileHandler, ftell($this->fileHandler)));
		$this->repo->ReleaseLock();
		return $result;

	}

	//Call publish instead of commit when user hits publish button (ie you have new text to save to disk)
	public function publish($text) {
		$this->save($text);
		$this->commit();
		$s = new SearchEngine();
		$s->updateVersion($this);
		$s->updateIndex();
		return true; //TODO: need to update repo->commit to return error code
	}
	
	public function commit() {
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
	
	public function getDocFromDisk() {
		//if(DEBUG) echo "Opening branch " . $this->branch;
		$this->repo->checkout($this->branch);
		return fread($this->fileHandler, 8192);
	}
	
	public function diff($otherVersion) {
		return $this->repo->diff($this, $otherVersion);
	}
	
	public function merge($otherVersion, &$diffs) {
		//TODO:parse diffs, open other version, undo changes
		
		$this->repo->merge($this, $otherVersion, $diffs);
		$this->commit();
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
	
	public function getVersionId(){
		return $this->versionId;
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
		$result = $db->execQuery($updateTimeQuery);
	
		if($result) {
			$db->execQuery("SELECT last_saved_time FROM Versions WHERE v_id='$this->versionId'");
			$row = $db->getNextRow();
			return ($this->lastSavedTime = $row["last_saved_time"]);		
		}
		else return false;
	}
	
	public function getName() {
		$db = new DB();
		$selectQuery = "SELECT v_name FROM Versions WHERE v_id='{$this->versionId}'";
		$db->execQuery($selectQuery);
		$row = $db->getNextRow();
		return $row["v_name"];
	}
	
	public function rename($newName) {
		$db = new DB();
		$newName = mysql_real_escape_string($newName);
		$renameQuery = "UPDATE Versions SET v_name = '$newName' WHERE doc_fk='{$this->docId}' AND u_fk='{$this->userId}'";
		return $db->execQuery($renameQuery);
	}
	
	public static function doesUserHaveVersion($doc_id, $u_id) {
		$db = new DB();
		$doc_id = mysql_real_escape_string($doc_id);
		$u_id = mysql_real_escape_string($u_id);
		
		$selectQuery = "SELECT v_id FROM Versions where doc_fk='$doc_id' AND u_fk='$u_id'";

		$db->execQuery($selectQuery);
		if($row = $db->getNextRow()){

			return $row["v_id"];
		}
		else return false;
	}
	
	public static function getVersionForUser($doc_id, $u_id, $version_to_clone, $description) {
		if($v_id = Version::doesUserHaveVersion($doc_id, $u_id)) {
			return new Version(0, 0, 0, 0, $v_id);
		}
		else {
			return Version::CreateNewVersion($doc_id, $u_id, $version_to_clone, $description);
		}
		
	}
	/*-------------------------------------------------------------------------------------------
	 * Version List Functions - list global docs, recent docs for a user, and recent versions
	 * that the user has a version of
	 *-------------------------------------------------------------------------------------------*/
	public static function getRecentGlobalVersions($n=0) {
		$db = new DB();
		$versions = array();
		$selectQuery = "SELECT doc_id as dId, name as dName, v_name as vName, v_id as vId, username, display_name as displayName, last_saved_time as timestamp, u_id as uId " .
			"FROM Versions INNER JOIN Documents " . 
			"ON Versions.doc_fk = Documents.doc_id " .
			"INNER JOIN Users " .
			"ON Versions.u_fk = Users.u_id " .
			"ORDER BY last_saved_time DESC";
		if($n > 0) $selectQuery .= " LIMIT 0, $n";
		$db->execQuery($selectQuery);
		while($row = $db->getNextRow()) {
			$row['timestamp'] = getLocalTime($row['timestamp']);
			$versions[] = $row;
		}
		return $versions;
	}
	
	public static function getRecentGlobalVersionsClean($n=0) {
		$versions = Version::getRecentGlobalVersions($n);
		foreach($versions as $k => $v)  {
			$versions[$k]["vName"] = stripslashes($versions[$k]["vName"]);
			$versions[$k]["dName"] = stripslashes($versions[$k]["dName"]);
			$versions[$k]["vName"] = $versions[$k]["vName"]? " - " . $versions[$k]["vName"] : "";
			$versions[$k]["link"] = "viewer.php?v_id=" . $versions[$k]["vId"];
			$versions[$k]["iconPtr"] = getIconPtr($versions[$k]["uId"]);
		}
		return $versions;
	}
	
	//get n most recent versions for User, everything if n =0
	//assume userId is sanitized (passed from User class)
	public static function getRecentVersionsForUser($userId, $n=0) {
		$db = new DB();
		$versions = array();
		$selectQuery = "SELECT doc_id as dId, name as dName, v_name as vName, v_id as vId, last_saved_time as timestamp, CONCAT(dept_name, course_num) as course " .
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
	
	public static function getRecentVersionsForUserClean($userId, $n=0) {
		$versions = Version::getRecentVersionsForUser($userId, $n);
		foreach($versions as $k => $v) {
			$versions[$k]["vName"] = stripslashes($versions[$k]["vName"]);
			$versions[$k]["course"] = $versions[$k]["course"]? $versions[$k]["course"] . ":": "";
			$versions[$k]["vName"] = $versions[$k]["vName"]? " - " . $versions[$k]["vName"] : "";
			$versions[$k]["dName"] = stripslashes($versions[$k]["dName"]);
			$versions[$k]["link"] = "editor.php?v_id=" . $versions[$k]["vId"];
		}
		return $versions;
		
	}
	
	//get n most recent versions for User, everything if n =0
	//assume userId is sanitized (passed from User class)
	public static function getRecentVersionFeedForUser($userId, $n=0, $filter=0) {
		$db = new DB();
		$versions = array();
		$selectQuery = "SELECT u_id as uId, doc_id as dId, name as dName, v_name as vName, v_id as vId, last_saved_time as timestamp, username, display_name as displayName " .
			"FROM Versions INNER JOIN Documents " . 
			"ON Versions.doc_fk = Documents.doc_id " .
			"INNER JOIN Users " .
			"ON Versions.u_fk = Users.u_id " .
			"WHERE doc_id IN " .
			"(SELECT doc_fk from Versions WHERE u_fk = '$userId') " .
			"AND u_fk != '$userId' ";
		if($filter) {
			$filterArr = Document::splitClassName($filter);
			$selectQuery .= "AND dept_name='{$filterArr[0]}' AND course_num='{$filterArr[1]}'";
		}
		$selectQuery .=
			"ORDER BY last_saved_time DESC";
		if($n > 0) $selectQuery .= " LIMIT 0, $n";
		$db->execQuery($selectQuery);
		while($row = $db->getNextRow()) {
			$row['timestamp'] = getLocalTime($row['timestamp']);
			$versions[] = $row;
		}
		return $versions;
	}
	
	public static function getRecentVersionFeedForUserClean($userId, $n=0, $filter=0) {
		$my_version_feed = Version::getRecentVersionFeedForUser($userId, $n, $filter);
		
		//preprocess to figure out links
		foreach($my_version_feed as $k => $v) {
			$my_version_feed[$k]["vName"] = stripslashes($my_version_feed[$k]["vName"]);
			$my_version_feed[$k]["vName"] = $my_version_feed[$k]["vName"]? " - " . $my_version_feed[$k]["vName"] : "";
			$my_version_feed[$k]["dName"] = stripslashes($my_version_feed[$k]["dName"]);
			$my_version_feed[$k]["iconPtr"] = getIconPtr($my_version_feed[$k]["uId"]);
			$my_version_feed[$k]["link"] = "viewer.php?v_id=" . $my_version_feed[$k]["vId"];
		}
		return $my_version_feed;
	}
}


?>
