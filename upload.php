<?php
require_once('config.php');

session_start();

require('init_smarty.php');

$smarty->display('upload.tpl');
?>