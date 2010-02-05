<?php

require_once(dirname(__FILE__) . "/../config.php");

require_once(dirname(__FILE__) . "/../classes/user.php");

function testCreateUser() {
	echo "Trying to create user dtran320...<br/>";
	$userExists = User::checkUserNameExists("dtran320");
	if($userExists) {
		echo "User dtran320 already exists...<br/>";
		$user = new User("dtran320");
	}
	else {
		"Trying to create new user dtran320...";
		$user = User::createNewUser("dtran320", "pass123", "pass123", "David");
		User::createNewUser("mlinsey", "asdf", "asdf", "Mark");
		if($user)
			echo "Created new user dtran320 successfully!<br/>";
		else {
			echo "Failed.<br/>";
			return false;
		}
	}
	echo "Testing that username is correct...";
	echo ($user->username == "dtran320")? "Yes!" : "No!";
	
	echo "<br/>Testing that display name is correct...";
	echo ($user->displayName == "David")? "Yes!" : "No!";
	echo "<br/>";

}

?>
