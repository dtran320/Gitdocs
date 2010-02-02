<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . "/../classes/user.php");

include('testUser.php');
include('testDocument.php');
include('testVersion.php');

echo "Running tests...<br/>";

testCreateUser();
testCreateDocument();
testCreateVersion();
echo "Done!";

?>
