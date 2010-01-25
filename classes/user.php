<?php

/* ----------------------------------------------------------------------------
 * User class
 * author: David
 * Object-relational mapping for Users table, handles user registration and login
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

class User {
	
	private $userId;
	private $username;
	private $passwordHash;
	private $displayName;
	private $iconPtr;
	
	public static function checkUserNameExists($name) {
		$name = mysql_real_escape_string($name);
		$selectQuery = "SELECT username FROM Users WHERE name='$name'";
		$result = mysql_query($select_query);
		return $result && ($row = mysql_fetch_assoc($result));
	}
	
	pubic static function createNewUser($name, $password, $password_confirm) {
		
	}
	
	public function __construct() {
		
	}
	
	public function checkAndDoLogin() {
		
	}
	
	public function logout() {
		
	}
	
}

?>