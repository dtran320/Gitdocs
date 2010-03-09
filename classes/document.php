<?php 
/* ----------------------------------------------------------------------------
 * Document class
 * Object-relational class for the documents 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../db/db.php");
require_once(dirname(__FILE__) . "/../lib/utils.php");

class Document {
	
	//attributes
	public $name, $docId, $type, $date, $class_name;
	
	//Creates a new document, creates file structure on disk, create in DB
	public static function CreateNewDocument($name = "New Document", $class_name = "GD 555", $date = "", $type = "") {
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
		$document->renameClass($class_name);
		if($date) { $document->setDate($date);}
		$document->setType($type);

		return $document;
	}
	
	public function __construct($docId, $name = 0){
		$this->docId = $docId;
		$db = new DB();
		$id = mysql_real_escape_string($this->docId);
		$query = "SELECT name, type, lecture_date, dept_name, course_num FROM Documents " .
			"WHERE doc_id='$id'";
		$db->execQuery($query);
		if($row = $db->getNextRow()) {
			$this->type = $row['type'];
			$this->date = $row['lecture_date'];
			$this->class_name = $row['dept_name'] . ' ' . $row['course_num'];
			$this->name = $row['name'];
		}
		
	}
	
	public static function getDocInfoForId($id) {
		$db = new DB();
		$id = mysql_real_escape_string($id);
		$docInfoQuery = "SELECT name, type, lecture_date, dept_name, course_num FROM Documents " .
			"WHERE doc_id='{$id}'";
		if (DEBUG) var_dump($docInfoQuery);
		$db->execQuery($docInfoQuery);
		$row = $db->getNextRow();
		$row['class_name'] = $row['dept_name'] . ' ' . $row['course_num'];
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

	public static function getNotesAndUsersForClass($className) {
		return array('notes' => Document::getNotesForClass($className), 
								'avatars' => Document::getAvatarsForClass($className));
	}

	public static function getAvatarsForClass($className) {
		$db = new DB();
		$split = Document::splitClassName($className);

		$query = 'SELECT DISTINCT u_fk as users FROM Documents INNER JOIN Versions on doc_id = doc_fk AND dept_name="' . $split[0] . '" AND course_num="' . $split[1] . '";';

		$db->execQuery($query);

		$avatars = array();
		while($row = $db->getNextRow()) {
			$avatars[] = getIconPtr($row['users']);
		}	
		return $avatars;		
	}

	public static function getNotesForClass($className) {
		$db = new DB();
		$split = Document::splitClassName($className);
		$query = "SELECT doc_id, name, lecture_date, type from Documents " .
			"INNER JOIN Versions on doc_id = doc_fk " .
			"WHERE dept_name='{$split[0]}' AND course_num='{$split[1]}' " .
		 	" GROUP BY doc_id ORDER BY lecture_date DESC;";
		$db->execQuery($query);

		$notes = array();
		$i = -1;
		$prev_date = '';
		$curr_date = '';
		while($row = $db->getNextRow()) {
			$curr_date = $row['lecture_date'];
			$type = $row['type'];
			if ($curr_date != $prev_date || $curr_date == '') {
				$i++;
				$notes[$i] = array('lecture_id' => '', 'lecture'=>'', 'reading'=>'', 'reading_id' =>'', 'lecture_date'=>'','final_id'=>'');
				$notes[$i]['lecture_date'] = $row['lecture_date'] != '' ? $row['lecture_date'] : 'unknown date';
			}
			$key = $type ._id;
			$doc_id = $row['doc_id'];
			$notes[$i][$key] = $doc_id;
			$notes[$i][$type] = $row['name'];
			$prev_date = $curr_date;		
		}	
		return $notes;
	}
	
	public function rename($newName) {
		//verify that the logged in user owns this doc later?
		$db = new DB();
		$newName = mysql_real_escape_string($newName);
		$renameQuery = "UPDATE Documents SET name = '$newName' WHERE doc_id='{$this->docId}'";
		return $db->execQuery($renameQuery);
	}

	public function setDate($date) {
		$db = new DB();
		if ($date == '') {
			$date = date('Y-m-d');
		}
		$query = "UPDATE Documents SET lecture_date = '{$date}' WHERE doc_id='{$this->docId}';";
		if($db->execQuery($query)) { 
			$this->date = $date; return true; 
		} else return false;
		
	}
	
	public function getName() {
		echo strlen($this->name);
		return strlen($this->name) > 0 && $this->name != "null"? stripslashes($this->name) : "";
	}

	public function getInfo() {
		return strlen($this->type) > 0 && $this->type != "null"? 
			ucfirst($this->type) . (strlen($this->date) > 0 && $this->date != "null "? " - {$this->date}": "") : "";
	}

	public function setType($type) {
		$db = new DB();
		if($type == '') {
			$type = 'lecture';
		}
		$query = "UPDATE Documents SET type = '{$type}' WHERE doc_id='{$this->docId}';";
		if($db->execQuery($query)) {
			$this->type = $type; return true;
		} else return false;
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

	public function getClassesForUser($userId) {
		$db = new DB();
		$classes = array();
		$query = "SELECT DISTINCT(CONCAT(dept_name, course_num)) as course FROM Documents " .
			"INNER JOIN Versions on doc_fk = doc_id " .
			"WHERE u_fk='$userId' GROUP BY doc_id ";
		$db->execQuery($query);
		while($row = $db->getNextRow())
			$classes[] = $row['course'];
		return $classes;
	}

	/*
	public static function getNormalizedDocName($type, $date, $title=0) {
		return ucfirst($type) . "_" . $date . ($title? "_" . ucfirst($title) : "");
	}
	*/
	public static function getDocForClassTypeAndDate($class, $type, $date) {
		$db = new DB();
		$classSplit = Document::splitClassName($class);
		$deptName = mysql_real_escape_string($classSplit[0]);
		$courseNum = mysql_real_escape_string($classSplit[1]);
//		$name = Document::getNormalizedDocName($type, $date);
		$type = mysql_real_escape_string($type);
		$date = mysql_real_escape_string($date);
		$query = "SELECT doc_id FROM Documents WHERE " .
			"course_num='$courseNum' AND dept_name='$deptName' AND " .
			"lecture_date = '$date' AND " .
			"type = '$type';";
/*
		$query = "SELECT doc_id FROM Documents WHERE " .
			"course_num='$courseNum' AND dept_name='$deptName' AND " .
			"name LIKE '$name%'";
*/
		$db->execQuery($query);
		if($row = $db->getNextRow()) return $row['doc_id'];
		else return false;
	}
	
}

?>
