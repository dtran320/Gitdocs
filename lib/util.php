<?php

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
	return htmlEscape(getVar($fieldName))
}

?>