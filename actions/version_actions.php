<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');

require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$action = postVarClean("action");
$d_id = postVarClean("d_id");
$u_id = postVarClean("u_id");
$doc_text = postVarClean("doc_text");

var_dump($doc_text . "sdfsf");

?>