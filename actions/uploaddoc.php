<?php
session_start();
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$doc = postVar('doc');

echo $doc;


?>