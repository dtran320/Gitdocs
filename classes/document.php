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
		if (DEBUG) var_dump($docInfoQuery);
		$db->execQuery($docInfoQuery);
		$row = $db->getNextRow();
		return $row;
	}

	public static function splitClassName($newClassName) {
		$newDeptName = "";
		$newCourseNum = "";
		for ($i = 0; $i < strlen($newClassName); $i++) {
			$char = substr($newClassName, $i, 1);
			if (!is_numeric($char)) {
				$newDeptName .= $char;
			} else {
				$newCourseNum = substr($newClassName, $i);
				break;
			}	
		}
		$newDeptName = strtoupper(trim($newDeptName));
		$newCourseNum = strtoupper(trim($newCourseNum));
		return array($newDeptName, $newCourseNum);
	}

	public static function getAllClasses() {
		// returns string with all classnames, separated by commas 
		$db = new DB();
		$query = "SELECT distinct dept_name, course_num FROM Documents ORDER BY dept_name, course_num;";
		$db->execQuery($query);
		$classes = '';
		while($row = $db->getNextRow()){
			$classes .= $row['dept_name'] . ' ' . $row['course_num'] . ',';
		}
		$classes = substr($classes, 0, strlen($classes)-1);
		return $classes;
	}

	public static function getNotesForClass($className) {
		$db = new DB();
		$split = Document::splitClassName($className);
		$query = "SELECT doc_id, name, count(v_id) as count, max(last_saved_time) as max_time from Documents " .
			"INNER JOIN Versions on doc_id = doc_fk " .
			"WHERE dept_name='{$split[0]}' AND course_num='{$split[1]}' " .
		 	" GROUP BY doc_id ORDER BY max_time DESC;";
		$db->execQuery($query);

		$notes = array();
		while($row = $db->getNextRow()) {
			$notes[] = $row;
		}	
		return $notes;
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


	public function renameClass($newClassName) {
		$db = new DB();
		$newClassName = mysql_real_escape_string($newClassName);

		// TODO: what about Computer Science 106a vs CS 106a vs CS106a vs cs106a etc etc??
		// currently the string up to the first number is the dept name
		// the remainder of the string is the course num
		$split = Document::splitClassName($newClassName);
		$newDeptName = $split[0];
		$newCourseNum = $split[1];
		$renameQuery = "UPDATE Documents SET dept_name = '$newDeptName', course_num = '$newCourseNum' WHERE doc_id='{$this->docId}'";
		return $db->execQuery($renameQuery);
	}
	
	//returns array containing each user's current version
	public function getAllVersions($n=0){
		$versions = array();
		$db = new DB();
		$query = "SELECT icon_ptr,v_name, display_name, last_saved_time as timestamp, u_id, v_id FROM Versions,Users WHERE doc_fk='{$this->docId}' AND u_id=u_fk";
		if($n>0)  $query .= " LIMIT 0, $n";
		$db->execQuery($query);
		while($row = $db->getNextRow()){
			$row['timestamp'] = getLocalTime($row['timestamp']);
			$versions[] = $row;
		}
		return $versions;
	}

	public function getClassName() {
		$db = new DB();
		$query = "SELECT dept_name, course_num FROM Documents WHERE doc_id='{$this->docId}';";
		$db->execQuery($query);
		$row = $db->getNextRow();
		return $row['dept_name'] . ' ' . $row['course_num'];		
	}

	
}

?>
