<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . "/../classes/user.php");

//require_once('testUser.php');
require_once('testDocument.php');
require_once('testVersion.php');
require_once('testDiff.php');
require_once('testMerge.php');

echo "Running tests...<br/>";
define("DEBUG", true);
//testCreateUser();
//testCreateDocument();
//testCreateVersion();
//testGetRecentVersionsForUser();
//testDiff();
testMerge();
echo "Done!";

?>
