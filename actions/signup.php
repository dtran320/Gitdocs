<?
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$username = postVar("username");
$password = postVar("password");
$passwordConfirm = postVar("password_confirm");
$displayName = postVar("display_name");

echo $displayName;

if($user = User::createNewUser($username, $password, $passwordConfirm, $displayName)) {
	$user->login();
	echo "SUCCESS";
}
else
	echo "FAILED";

?>