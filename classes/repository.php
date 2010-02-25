<?php

/* ----------------------------------------------------------------------------
 * Version class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config.php");

class Repository {

	private $location;
	private $lock_fh;

	public function __construct($location) {
		$this->location = $location;
	}	
	public static function CreateNewRepository($docId, $userId,$versionToClone = 0) {
		global $DOCUMENTS_PATH;
		$location = "$DOCUMENTS_PATH$docId/$userId";
		if(DEBUG) echo "new repo location:$location\n";
		if($versionToClone) {
			$parent_version = new Version(0, 0, 0, 0, $versionToClone);
			$otherRepoLocation = $parent_version->getRepoLocation();
			$command = "cd $location/..; git clone $otherRepoLocation $location 2>&1";
			$output = runCommand($command);
			$version = new Version($docId, $userId);
			$version->save($parent_version->getDocFromDisk());
			
		} else {
			//okay to go here?
			mkdir("$location", 0777);
			
			$fh = fopen("$location/document.html",'x');
			fclose($fh);	
			$command = "cd $location ; git init; git add document.html; git commit -a -m first-commit";
			$result = runCommand($command);
		}
		return new Repository($location);
	}

	public function GetLocation() {
		return $this->location;
	}
	

	public function AcquireLock() {
		$this->lock_fh = fopen("$this->location/.lock", "w+");
		$retVal = flock($this->lock_fh, LOCK_EX);
		if(!$retVal) echo "FAILED GETTING LOCK!";
		return $retVal;
	}	
	public function ReleaseLock() {
		flock($this->lock_fh, LOCK_UN);
		fclose($this->lock_fh);
	}
	
	public function commit() {	
		if(!$this->AcquireLock()) return false;
		$command = "cd $this->location; git add document.html; git commit -a -m placeholdercommitmsg";
		runCommand($command);			
		$this->ReleaseLock();
	}
	
	public function getFile($branch = 0) {
		if(!$this->AcquireLock()) return false;
		if(!$branch) $branch = "master";
		$this->checkout($branch);
		$fh = fopen("{$this->location}/document.html",'r+');
		$this->ReleaseLock();
		return $fh;
	}

	public function readFileToArray($branch = 0) {
		if(!$this->AcquireLock()) return false;	
		if(!$branch) $branch = "master";
		$this->checkout($branch);
		return file("$this->location/document.html");
		$this->ReleaseLock();
	}
	
	public function checkout($branch){	
		$command = "cd $this->location; git checkout $branch";
		runCommand($command);
	}
	
	public function diff($myVersion, $otherVersion) {
		$myVersion->commit();
		if(!$this->AcquireLock()) return "ERROR: COULD NOT ACQUIRE LOCK\n";
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
		runCommand($command);
		$command = "cd $this->location; git remote";
		$branchesList = runCommand($command);
		if(in_array($otherVersion->getUserId(), $branchesList)) {	
			$command ="cd $this->location; git fetch ". $otherVersion->getUserID();
		} else {
			$command = "cd $this->location; 
			 	git remote add -t ". $myVersion->getUserId() ." -f ". $otherVersion->getUserId() ." $otherLocation;";
		}		
		if(DEBUG) echo "command: $command \n";
		runCommand($command);
		//TODO: use real file length instead of big constant
		$command = "cd $otherLocation; git checkout " . $myVersion->getUserId() . "; cd $this->location; git checkout master;";
		runCommand($command);
		$command = "diff -U10000 $this->location/document.html $otherLocation/document.html"; 
		
		if(DEBUG) echo "command: $command \n";
		$result = runCommand($command);
		$this->ReleaseLock();
		return $result;
						
	}
	
	
	
	public function merge($myVersion, $otherVersion, &$arrDiffs) {
		
		$otherLocation = $otherVersion->getRepoLocation();
	 	$myFileArr = $myVersion->readFileToArray();
		$otherFileArr = $otherVersion->readFileToArray($myVersion->getUserId());	
	
		if(!$this->AcquireLock()) return false;
		//get diff between each version
		$command = "cd $this->location; git checkout master; cd $otherLocation git checkout " . $myVersion->getUserId() . "; diff -U0 $this->location/document.html $otherLocation/document.html";
		if(DEBUG) echo "command: $command \n";
		$diffResult = runCommand($command);
		$diffResult = implode("\n", $diffResult);
	
		//find all changes in diff (marked by format @@ -line#,len +line#,len @@ in diff output
		preg_match_all('/\n@@ -(\d+),?(\d+)? \+(\d+),?(\d+)?/', $diffResult, $diffLineNums);
		$split = preg_split('/\n@@ -(\d+),?(\d+)? \+(\d+),?(\d+)?/', $diffResult);
		//print_r($diffLineNums);
		//print_r($split);
		//in git diff, "2," means the edit starting on line 2 was one line long (not zero). update diffLineNums to reflect this.
		foreach($diffLineNums[4] as $index => $curr) {if($curr==="") $diffLineNums[4][$index]=1;}
		foreach($diffLineNums[2] as $index => $curr) {if($curr==="") $diffLineNums[2][$index]=1;}
		//print_r($diffLineNums);

		if(DEBUG)  print_r($arrDiffs);	
		
		//print_r($split);
		foreach($split as $index =>$currSplit) {
			if(DEBUG)echo "\ncurr split:$currSplit\n";
			if(DEBUG)echo preg_match('/(\n-\t.*)+(\n\+\t.*)/', $currSplit);
			if(preg_match('/(\n-\t.*)+(\n\+\t.*)/', $currSplit) + preg_match('/(\n\+\t.*)+(\n-\t.*)/', $currSplit) > 0) {
				for($i = 1; $i<5; $i++) {	
					array_splice($diffLineNums[$i], $index - 1, 0, $diffLineNums[$i][$index - 1]);
				}
				$diffLineNums[4][$index-1] = 0;
				$diffLineNums[2][$index] = 0;	
		//print_r($diffLineNums);
			}
		}	
		//undo changes which were rejected
		
			if(DEBUG)print_r($myFileArr);
			if(DEBUG)print_r($otherFileArr);
		foreach(array_reverse($arrDiffs) as $diff) {//reversed so offsets for later diffs aren't affected
			$myEdit = array_slice($myFileArr, $diffLineNums[1]["$diff->index"] -1, (int)$diffLineNums[2]["$diff->index"]);
			$otherEdit = array_slice($otherFileArr, $diffLineNums[3]["$diff->index"] - 1, (int)$diffLineNums[4]["$diff->index"]);
			if($diff->userAction == UserDiffAction::accepted) {
				if ($diff->type == DiffType::del)
					array_splice($myFileArr, $diffLineNums[1]["$diff->index"]-1, (int)$diffLineNums[2]["$diff->index"] );	
				else
					array_splice($myFileArr, $diffLineNums[1]["$diff->index"], (int)$diffLineNums[2]["$diff->index"], $otherEdit);
			} else if($diff->userAction == UserDiffAction::rejected) {
				//if($diff->type == DiffType::del)
					//array_splice($otherFileArr, $diffLineNums[3]["$diff->index"], (int)$diffLineNums[4]["$diff->index"], $myEdit);	
				//else
					//array_splice($otherFileArr, $diffLineNums[3]["$diff->index"] - 1, (int)$diffLineNums[4]["$diff->index"], $myEdit);	
			}
		}	

			if(DEBUG)print_r($myFileArr);
			if(DEBUG)print_r($otherFileArr);
		$myFile = $myVersion->openVersionFile();
		foreach($myFileArr as $line) { fwrite($myFile,$line);}
		ftruncate($myFile, ftell($myFile));
		fclose($myFile);
		$myVersion->commit();	
		
		$otherFile = $otherVersion->openVersionFile($myVersion->getUserId());
		foreach($otherFileArr as $line) { fwrite($otherFile,$line);}
		ftruncate($otherFile, ftell($otherFile));
		fclose($otherFile);	
		$otherVersion->commit();
	
		$command = "cd $this->location; git fetch ". $otherVersion->getUserId() . ";git merge ". $otherVersion->getUserId(). "/" . $myVersion->getUserId(); 
		//$err= runCommand($command);	
		$command = "cd $otherLocation; git checkout master";
		runCommand($command);	
		$this->ReleaseLock();
	}

}

?>
