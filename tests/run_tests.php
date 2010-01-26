<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . "/../classes/user.php");

include('testUser.php');

echo "Running tests...";

testCreateUser();

?>