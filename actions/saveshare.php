<?php
session_start();
require_once(dirname(__FILE__) . '/../classes/user.php');
require_once(dirname(__FILE__) . '/../classes/document.php');
require_once(dirname(__FILE__) . '/../classes/version.php');
require_once(dirname(__FILE__) . '/../lib/utils.php');

$action = postVarClean("action");
$d_id = postVarClean("d_id");
$u_id = postVarClean("u_id");

//echo 1 as status for success, 0 for fail... might want to make this JSON with a status and specific errors

if($action=="Save") {
	$docText = postVar("editor1");
	$version = new Version($d_id, $u_id);
	$status = $version->save($docText);
	if($status) echo "1";
	else echo "0";
}

else if ($action=="Save and Publish"){
    	$docText = postVar("editor1");
        $version = new Version($d_id, $u_id);
        $status = $version->publish($docText);
        if($status) echo "Last saved " . getLocalTime($version->lastSavedTime);
        else echo "0";	
}

else if ($action=="renameV") {
	$versionName = postVar("v_name");
	$version = new Version($d_id, $u_id);
	if($version->rename($versionName)) echo "1";
	else echo "0";
}

else if ($action=="renameD") {
	$docName = postVar("d_name");
	$doc = new Document($d_id);
	if($doc->rename($docName)) echo "1";
	else echo "0";
	
}

else if($action=="updateHistory") {
	$version = new Version($d_id, $u_id);
	echo $json_encode($version->getVersionHistory());
}

?>
