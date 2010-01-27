<?
session_start();


ini_set('display_errors', 1);
error_reporting(E_ALL);

require('smarty_lib/Smarty.class.php');

require('classes/user.php');

$smarty = new Smarty();
$smarty->template_dir = 'smarty/templates';
$smarty->config_dir = 'smarty/configs';
$smarty->compile_dir = 'smarty/templates_c';
$smarty->cache_dir = 'smarty/cache';

if($user = User::getLoggedInUser()) {
	echo "user logged in!";
}
$smarty->display('landing.tpl');
?>

