<?
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$username = postVar("username");
$password = postVar("password");
$passwordConfirm = postVar("password_confirm");
$displayName = postVar("first_name") . " " . postVar("last_name");

if($user = User::createNewUser($username, $password, $passwordConfirm, $displayName)) {
	$user->login();
	if(isset($_SESSION['return_page'])) echo $_SESSION['return_page'];
	else echo 'index.php';
}
else
	echo 0;

?>