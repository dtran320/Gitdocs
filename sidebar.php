<?	

/* where should this go anyway?
*/
function getHistory($versionName, $document) {
	return array(
					array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>{$versionName}</span>, which you saved 5m ago"),
					array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>{$document->name}</span> 5m ago"),
					);
}
function getClassmates($document, $user) {
		$versions = $document->getAllVersions();
		$others = array();
		foreach($versions as $row) {
			$v_name = stripslashes($row['v_name']);
			if($row['u_id'] == $user->userId) continue;		
			$others[] = array("names"=>"<a class=\"v_name\">$v_name</a><br/>by $row[display_name] $row[timestamp]", "uid"=>$row['u_id'], "vid"=>$row['v_id'], "iconPtr"=> getIconPtr($row["u_id"]));
		}
	return $others;
}
	

?>
