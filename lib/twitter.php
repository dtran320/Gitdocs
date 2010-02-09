<?php

require_once('curl.php');

function getGitdocsUpdates($n) {
	
	$updates = array();
	
	$curl = new Curl();
	$url = "http://twitter.com/statuses/user_timeline/gitdocs.json?count=$n";
	
	$results = $curl->getResultsForURL($url);
	if($results->info == 200) {
	
		$twitter_results = json_decode($results->transferResult);
		if($twitter_results && sizeof($twitter_results) > 0) {
			foreach($twitter_results as $twitter_result) {
				$updates[] = array("update_text" => $twitter_result->text, "update_time" => getLocalTime(strtotime($twitter_result->created_at)));
			}
		} //end if valid results
	} //end if code is 200
	return $updates;
	
}

?>