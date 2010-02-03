<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

class Repository {

	private $location;

	public function __construct($location) {
		$this->location = $location;
	}	
	
	public static function CreateNewRepository($docId, $userId,$versionToClone = 0) {
		global $DOCUMENTS_PATH;
		$location = "$DOCUMENTS_PATH$docId/$userId";
		echo "new repo location:$location\n";
		if(!mkdir("$location", 0700)) return false;				  
		if($versionToClone) {
			$otherRepoLocation = $versionToClone->getRepoLocation();
			$command = "cd $location; git clone $otherRepoLocation";
			//TODO: Escape this? necessary?
			exec($command);
		} else {
			$fh = fopen("$location/document.html",'x');
			//TODO:setup html boilerplate here
			fclose($fh);	
			$command = "cd $location ; git init";
			exec($command);
		}
		return new Repository($location);
	}

	public function GetLocation() {
		return $this->location;
	}
	
	public function commit() {
		$command = "cd $location; git commit -a -m placeholdercommitmsg";
		exec($command);
	}
	
	public function getFile() {
		$fh = fopen("$this->location/document.html",'w+');
		return $fh;
	}
	
	public function diff($myVersion, $otherVersion) {
		$myVersion->commit();
		$otherLocation = $otherVersion->getRepoLocation();
		$command = "cd $otherLocation; 
				git stash; 
				git branch $myVersion->getUserId(); 
				git checkout $myversion->getUserId(); 
			    	git merge master;"
	}
	
	public function merge($otherVersion) {

	}

}

?>
