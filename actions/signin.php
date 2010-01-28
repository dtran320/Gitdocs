<?
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$username = postVar("username");
$password = postVar("password");

$user = new User($username);
if($user && $user->checkAndDoLogin($password))
	echo "SUCCESS";
else
	echo "FAILED";

?>