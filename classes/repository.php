<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

class Repository {

	private $location;
	private $currentBranch;
	public function __construct($location) {
		$this->location = $location;
	}	
	
	public static function CreateNewRepository($docId, $userId,$versionToClone = 0) {
		global $DOCUMENTS_PATH;
		$location = "$DOCUMENTS_PATH//$docId//$userId";
		if(!mkdir("$location", 0600)) return false;				  if(!versionToClone) {
			$otherRepoLocation = $versionToClone->getRepoLocation();
			$command = "$location//git clone $otherRepoLocation";
			//TODO: Escape this? necessary?
			exec($command);
		} else {
			//TODO: create starter document file here
			if(!mkdir("$location//.git", 0600) return false);
			$command = "$location//.git//git --bare init";
			exec($command);
		}
		return new Repository($location);
	}

	public function GetLocation() {
		return $location;
	}
	
	public function commit() {
		$command = "$location//git commit -a -m mycommit";
		exec($command);
	}
	
	public function getFile() {
		$fh = fopen("$location//document.html",'w+');
		return $fh;
	}
	
	public function diff($otherVersion) {
	}
	
	public function merge($otherVersion) {

	}

}

?>
