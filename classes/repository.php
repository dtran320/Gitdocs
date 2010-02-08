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
		if(!mkdir("$location", 0700)) {
			// TODO: if can't make dir, then it could already exist
			// but this is potentially hazardous
			return new Repository($location);			
		}
		if(DEBUG) echo "new repo location:$location\n";
		if($versionToClone) {
			$parent_version = new Version(0, 0, 0, 0, $versionToClone);
			$otherRepoLocation = $parent_version->getRepoLocation();
			$command = "cd $location/..; git clone $otherRepoLocation $location";
			//TODO: Escape this? necessary?
			exec($command);
			$version = new Version($docId, $userId);
			$version->save($parent_version->getDocFromDisk());
			
		} else {
			$fh = fopen("$location/document.html",'x');
			fclose($fh);	
			$command = "cd $location ; git init; git add document.html; git commit -a -m first-commit";
			exec($command);
		}
		return new Repository($location);
	}

	public function GetLocation() {
		return $this->location;
	}
	
	public function commit() {
		$command = "cd $this->location; git commit -a -m placeholdercommitmsg";
		exec($command);
	}
	
	public function getFile($branch = 0) {
		if(!$branch) $branch = "master";
		$this->checkout($branch);
		$fh = fopen("$this->location/document.html",'w+');
		return $fh;
	}

	public function readFileToArray($branch = 0) {
		if(!$branch) $branch = "master";
		$this->checkout($branch);
		return file("$this->location/document.html");
	}
	
	private function checkout($branch){	
		$command = "cd $this->location; git checkout $branch";
		exec($command);
	}
	
	public function diff($myVersion, $otherVersion) {
		$myVersion->commit();
		$otherLocation = $otherVersion->getRepoLocation();
		$command = "cd $otherLocation; 
				git stash; 
				git branch ". $myVersion->getUserId() ."; 
				git checkout ". $myVersion->getUserId(). "; 
				echo document.html merge=discardMine > $otherLocation/.gitattributes;
				git config merge.discardMine.name \"discard my changes if conflicts\";
				git config merge.discardMine.driver \"".dirname(__FILE__). "/../scripts/discardMine.sh %0 %A %B\";
				git commit -a -m 'prepared branch merge strategy';
			    	git merge master;";
		echo "command: $command \n";
		exec($command);
		exec("cd $this->location; git remote", $branchesList);
		if(in_array($otherVersion->getUserId(), $branchesList)) {	
			$command ="cd $this->location; git fetch ". $otherVersion->getUserID();
		} else {
			$command = "cd $this->location; 
			 	git remote add -t ". $myVersion->getUserId() ." -f ". $otherVersion->getUserId() ." $otherLocation;";
		}		
		echo "command: $command \n";
		exec($command);
		$command = "cd $this->location; git checkout master; git diff -U10000 ". $otherVersion->getUserId() ."/". $myVersion->getUserId();
		
		echo "command: $command \n";
		exec($command, $result);
		return array_slice($result, 1);
						
	}
	
	
	
	public function merge($myVersion, $otherVersion, &$arrDiffs) {
	 	$myFileArr = $myVersion->readFileToArray();
		$otherFileArr = $otherVersion->readFileToArray($myVersion->getUserId());	
	  	$command = "cd $this->location; git checkout master; git diff -U0 ".$otherVersion->getUserId() ."/".$myVersion->getUserId();
		echo "command: $command \n";
		exec($command, $diffResult);
		$diffResult = implode("\n", $diffResult);
		preg_match_all('/\n@@ -(\d+),?(\d+)? \+(\d+),?(\d+)?/', $diffResult, $diffLineNums);	
		 		
		//undo changes which were rejected
		foreach($arrDiffs as $diff) {
			if($userAction == Diff::rejected) {
				array_splice($otherFileArr, $diffLineNums[2], $diffLineNums[3]);	
			} else if($userAction == Diff::accepted) {
				array_splice($otherFileArr, $diffLineNums[0], $diffLineNums[1]);	
			}
		}	
		$myfile = $myVersion->openVersionFile();
		foreach($myFileArr as $line) { fwrite($myfile,$line);}
		fclose($myFile);
		$myVersion->commit();	
		
		$otherFile = $otherVersion->openVersionFile($myVersion->getUserId());
		foreach($otherFileArr as $line) { fwrite($otherFile,$line);}
		fclose($otherFile);	
		$otherVersion->commit();
	
		$command = "cd $this->location; git merge $otherVersion->userId/$myVersion->userId"; 
		$exec($command, $err);
		if($err) {
			echo "Merge Error! $result";
		}
	}

}

?>
