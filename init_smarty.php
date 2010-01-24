<?
require('smarty_lib/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = 'smarty/templates';
$smarty->config_dir = 'smarty/configs';
$smarty->compile_dir = 'smarty/templates_c';
$smarty->cache_dir = 'smarty/cache';
?>
