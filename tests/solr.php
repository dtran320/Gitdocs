<?php
require_once("../classes/version.php");
require_once("../classes/searchEngine.php");
$s = new SearchEngine();
//$s->runQuery("original");
//$s->indexAll();
$v = new Version(0,0,0,0,12);
$s->updateVersion($v);
$s->updateIndex();
?>
