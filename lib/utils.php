<?php

require_once(dirname(__FILE__) . '/../config.php');

/* ----------------------------------------------------------------------------
 * General library functions
 * author: David
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

//Use: $arr = mysqlEscapeArray($arr)
function mysqlEscapeArray($arr) {
	foreach($arr as $k => $v)
		$arr[$k] = mysql_real_escape_string($v);
	return $arr;
}

function htmlEscape($v) {
	return htmlspecialchars($v, ENT_QUOTES);
}

function postVar($fieldName) {
	return isset($_POST[$fieldName])? $_POST[$fieldName] : "";
}

function postVarClean($fieldName) {
	return htmlEscape(postVar($fieldName));
}

function getVar($fieldName) {
	return isset($_GET[$fieldName])? $_GET[$fieldName] : "";
}

function getVarClean($fieldName) {
	return htmlEscape(getVar($fieldName));
}

function getLocalTime($time) {
	date_default_timezone_set('America/Los_Angeles');
	return date("M d Y h:i A", $time);
}

function runCommand($command) {
	//$command = escapeshellcmd($command);
	$output = array();
	exec($command, $output);
	if(LOG) {
         	global $LOG_PATH;
                $log = fopen("$LOG_PATH", "a");
                fwrite($log, "\ncommand:$command\noutput:\n".implode('\n',$output)). "\n________\n";
                fclose($log);
        }
	return $output;
}

?>
