<?	

function getHistory($versionName, $document) {
	return array(
					array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>{$versionName}</span>, which you saved 5m ago"),
					array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>{$document->name}</span> 5m ago"),
					);
}
function getClassmates($user, $document) {
		$versions = $document->getAllVersions();
		$others = array();
		foreach($versions as $row) {
			if($row['u_id'] == $user->userId) continue;		
			if(!$row['icon_ptr']) $row['icon_ptr'] = 'images/bella8.jpg';
			$others[] = array($row['icon_ptr'], "<a class=\"v_name\">$row[v_name]</a><br/>by $row[display_name] $row[timestamp]", $row['u_id']);
		}
	return $others;
}
	

?>
