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
/*
		if(!mkdir("$location", 0777)) {
			// TODO: if can't make dir, then it could already exist
			// but this is potentially hazardous
			return new Repository($location);			
		}
		*/
		if(DEBUG) echo "new repo location:$location\n";
		if($versionToClone) {
			$parent_version = new Version(0, 0, 0, 0, $versionToClone);
			$otherRepoLocation = $parent_version->getRepoLocation();
			$command = "cd $location/..; git clone $otherRepoLocation $location";
			//TODO: Escape this? necessary?
			$output = array();
			exec($command, $output);
			var_dump($output);
			$version = new Version($docId, $userId);
			$version->save($parent_version->getDocFromDisk());
			
		} else {
			//okay to go here?
			mkdir("$location", 0777);
			
			$fh = fopen("$location/document.html",'x');
			fclose($fh);	
			$command = "cd $location ; git init; git add document.html; git commit -a -m first-commit";
			exec($command, $result);
		}
		return new Repository($location);
	}

	public function GetLocation() {
		return $this->location;
	}
	
	public function commit() {
		$command = "cd $this->location; git add document.html; git commit -a -m placeholdercommitmsg";
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
	
	public function checkout($branch){	
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
		if (DEBUG) echo "command: $command \n";
		exec($command);
		exec("cd $this->location; git remote", $branchesList);
		if(in_array($otherVersion->getUserId(), $branchesList)) {	
			$command ="cd $this->location; git fetch ". $otherVersion->getUserID();
		} else {
			$command = "cd $this->location; 
			 	git remote add -t ". $myVersion->getUserId() ." -f ". $otherVersion->getUserId() ." $otherLocation;";
		}		
		if(DEBUG) echo "command: $command \n";
		exec($command);
		//TODO: use real file length instead of big constant
		$command = "cd $otherLocation; git checkout " . $myVersion->getUserId() . "; cd $this->location; git checkout master;";
		exec($command);
		$command = "diff -U10000 $this->location/document.html $otherLocation/document.html"; 
		
		if(DEBUG) echo "command: $command \n";
		exec($command, $result);
		return $result;
						
	}
	
	
	
	public function merge($myVersion, $otherVersion, &$arrDiffs) {
		
		$otherLocation = $otherVersion->getRepoLocation();
		$command = "cd $this->location; git checkout master; cd $otherLocation git checkout " . $myVersion->getUserId() . "; diff -U0 $this->location/document.html $otherLocation/document.html";
	  	//$command = "cd $this->location; git checkout master; git diff -U0 ".$otherVersion->getUserId() ."/".$myVersion->getUserId();
		if(DEBUG) echo "command: $command \n";
		exec($command, $diffResult);
		$diffResult = implode("\n", $diffResult);
		preg_match_all('/\n@@ -(\d+),?(\d+)? \+(\d+),?(\d+)?/', $diffResult, $diffLineNums);	

		//in git diff, "2," means the edit was one line long (not zero). update diffLineNums to reflect this.
		foreach($diffLineNums[4] as $index => $curr) {if($curr==="") $diffLineNums[4][$index]=1;}
		foreach($diffLineNums[2] as $index => $curr) {if($curr==="") $diffLineNums[2][$index]=1;}
		if(DEBUG) print_r($diffLineNums);

		if(DEBUG) print_r($arrDiffs);	
			
	 	$myFileArr = $myVersion->readFileToArray();
		$otherFileArr = $otherVersion->readFileToArray($myVersion->getUserId());	
		//undo changes which were rejected
		
			if(DEBUG)print_r($myFileArr);
			if(DEBUG)print_r($otherFileArr);
		foreach($arrDiffs as $diff) {
			if($diff->userAction == UserDiffAction::accepted) {
				array_splice($myFileArr, $diffLineNums[1]["$diff->index"] - 1, (int)$diffLineNums[2]["$diff->index"]);	
			} else if($diff->userAction == UserDiffAction::rejected) {
				array_splice($otherFileArr, $diffLineNums[3]["$diff->index"] - 1, (int)$diffLineNums[4]["$diff->index"]);	
			}
		}	

			if(DEBUG)print_r($myFileArr);
			if(DEBUG)print_r($otherFileArr);
		$myfile = $myVersion->openVersionFile();
		foreach($myFileArr as $line) { fwrite($myfile,$line);}
		fclose($myfile);
		$myVersion->commit();	
		
		$otherFile = $otherVersion->openVersionFile($myVersion->getUserId());
		foreach($otherFileArr as $line) { fwrite($otherFile,$line);}
		fclose($otherFile);	
		$otherVersion->commit();
	
		$command = "cd $this->location; git fetch ". $otherVersion->getUserId() . ";git merge ". $otherVersion->getUserId(). "/" . $myVersion->getUserId(); 
		exec($command, $err);
		
	}

}

?>
