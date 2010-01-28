<?php

/* ----------------------------------------------------------------------------
 * Super lightweight db class - does almost nothing
 * author: David
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

require_once(dirname(__FILE__) . "/../config.php");

class DB {
	private $conn, $last_result, $last_query, $last_row;
	
	function __construct() {
		$this->conn = "";
		$this->last_result = false;
		$this->last_query = false;
		$this->last_row = false;
		$this->open();
	}
	
	function __destruct() {
		//not necessary?
		//$this->close();
	}	
	
	function open() {
		global $DATABASE_SETTINGS;
		$this->openWithParams($DATABASE_SETTINGS["host"], $DATABASE_SETTINGS["username"],
			$DATABASE_SETTINGS["password"], $DATABASE_SETTINGS["dbname"]);
	}
	
	function openWithParams($host, $user, $pass, $dbname) {
		$this->conn = mysql_connect($host, $user, $pass);
    	if (!$this->conn){
      		echo( "<p>Unable to connect to database manager.</p>");
        	die('Could not connect: ' . mysql_error($this->conn));
      		exit();
    	}
    	$this->selectDB($dbname);
	}
	
	function selectDB($name) {
		 	mysql_select_db($name, $this->conn);
	}
	
	//returns result - make sure this is properly escaped, returns the result
	function execQuery($query) {
		$this->last_query = $query;
		$this->last_result = mysql_query($query, $this->conn);
		if(DEBUG && mysql_errno($this->conn)) {
    		echo "MySQL error #" . mysql_errno($this->conn) . ": " . mysql_error($this->conn) . "\n";
			return false;
		}
		return $this->last_result;
	}
	
	function getNextRow() {
		if($this->last_result) {
			$this->last_row = mysql_fetch_assoc($this->last_result);
			return $this->last_row;
		}
		else return false;
	}	
	
	function getInsertedID() {
		if($this->last_result) {
			return mysql_insert_id($this->conn);
		}	
	}
}

?>
