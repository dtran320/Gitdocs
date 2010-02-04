<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");

class Repository {

	private $location;

	public function __construct($location) {
		$this->location = $location;
	}	
	
	public static function CreateNewRepository($docId, $userId,$versionToClone = 0) {
		global $DOCUMENTS_PATH;
		$location = "$DOCUMENTS_PATH$docId/$userId";
		if(DEBUG) echo "new repo location:$location\n";
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
				echo document.html merge=discardMine > $otherLocation/.gitattributes;
				git config merge.discardMine.name \"discard my changes if conflicts\";
				git config merge.keepMine.driver \"".dirname(__FILE__). "/../scripts/discardMine.sh %0 %A %B\";
				git commit -a -m 'prepared branch merge strategy';
			    	git merge master;";
		exec($command);
	}
	
	public function merge($otherVersion) {

	}

}

?>
