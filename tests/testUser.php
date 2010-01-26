<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/user.php");

function testCreateUser() {
	$user = User::createNewUser("dtran320", "pass123", "pass123", "David");
	var_dump($user);
}

?>