<?php

/* ----------------------------------------------------------------------------
 * User class
 * author: David
 * Object-relational mapping for Users table, handles user registration and login
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../db/db.php");
require_once(dirname(__FILE__) . "/../lib/utils.php");
class User {
	
	private $userId, $salt;
	public $username, $passwordHash, $displayName, $iconPtr;
	
	public static function checkUserNameExists($username) {
		$db = new DB();
		$username = mysql_real_escape_string($username);
		$selectQuery = "SELECT username FROM Users WHERE username='$username'";
		$db->execQuery($selectQuery);
		if($row = $db->getNextRow()) return true;
		return false;
	}
	
	public static function createNewUser($username, $password, $passwordConfirm, $displayName = 0, $iconPtr = 0) {
		if(!$username || !$password || !$passwordConfirm) return false;
		if($password != $passwordConfirm) return false;
		if(User::checkUserNameExists($username)) return false;
		$db = new DB();
		$salt = substr(md5(rand()), 0, 4);
	    $passwordHash= md5($password.$salt);
		$arr = array("username" => $username, "displayName" => $displayName, "iconPtr" => $iconPtr);
		$arr = mysqlEscapeArray($arr);
	
		$createUserQuery = "INSERT INTO Users(username, pwd_hash, salt, display_name, icon_ptr) " .
			"VALUES('{$arr["username"]}', '{$passwordHash}', '{$salt}', '{$arr["displayName"]}', '{$arr["iconPtr"]}')";
		
		$db->execQuery($createUserQuery);
		$user = new User($username);
		$user->login();
		return new User($username);
	}
	
	public static function getLoggedInUser() {
		return isset($_SESSION["username"])? new User($_SESSION["username"]) : false;
	}
	
	public function __construct($username, $passwordHash=0, $displayName = 0, $iconPtr = 0) {
		$this->username = $username;
		$db = new DB();
		$username = mysql_real_escape_string($username);
		$userSelectQuery = "SELECT username, pwd_hash, display_name, icon_ptr, salt " .
			"FROM Users WHERE username='{$username}'";
		$db->execQuery($userSelectQuery);
		if($row = $db->getNextRow()) {
			$this->passwordHash = $row["pwd_hash"];
			$this->displayName = $row["display_name"];
			$this->iconPtr = $row["icon_ptr"];
			$this->salt = $row["salt"];
		}
		else return false;
	}
	
	public function login() {
		$_SESSION["username"] = $this->username;
	}
	
	public function checkAndDoLogin($password) {
		$passwordHash = md5($password.$this->salt);
		if($passwordHash == $this->passwordHash) {
			$this->login();
			return true;
		}
		else return false;
	}
	
	//should this be static? Probably not...
	public static function logout() {
		//faster & cleaner than calling unset?
		$_SESSION = array();
	}

	
}

?>