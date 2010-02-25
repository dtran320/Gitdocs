<?php
//require_once('utils.php');
function getHtmlFromWordDoc($docLocation) {

  //use abiword to convert the word doc to html file
  $htmlFile = str_ireplace(".docx", ".html", $docLocation);
  $htmlFile = str_ireplace(".doc", ".html", $htmlFile);
  $process = popen("/usr/bin/abiword --plugin AbiCommand 2 >& 1", "w");
  if(is_resource($process)) {
    fputs($process, "convert $docLocation $htmlFile html");
    pclose($process);
  }
  if(file_exists($htmlFile)) {
    //open html file and spit out contents
    $fileHandle = fopen($htmlFile, 'r');
    return array("htmlFile" => $htmlFile, "content" => fread($fileHandle, '8192'));
  } else return false;
    
}

function getDocTitle($docPath) {
  $docPath = basename($docPath);
  if(preg_match("/.doc|.docx/", $docPath) == 0) return false;
  else {
    $docPath = str_ireplace(".docx", "", $docPath);
    return str_ireplace(".doc", "", $docPath);
  }
}

?>