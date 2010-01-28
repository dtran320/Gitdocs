<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . "/../classes/user.php");

include('testUser.php');
include('testDocument.php');

echo "Running tests...<br/>";

testCreateUser();
testCreateDocument();
echo "Done!";

?>
