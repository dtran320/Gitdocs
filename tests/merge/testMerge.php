<?php

require_once(dirname(__FILE__) . "/../../config.php");
require_once(dirname(__FILE__) . "/../../classes/user.php");
require_once(dirname(__FILE__) . "/../../classes/repository.php");
require_once(dirname(__FILE__) . "/../../classes/version.php");
require_once(dirname(__FILE__) . "/../../classes/diff.php");
require_once(dirname(__FILE__) . "/../../lib/utils.php");


        $userExists = User::checkUserNameExists("testbotA");
        $testbotA = $userExists ? new User("testbotA") : User::createNewUser("testbotA", "asdf", "asdf", "testbotA");
	$userExists = User::checkUserNameExists("testbotB");
       	$testbotB =  $userExists ? new User("testbotB") : User::createNewUser("testbotB", "asdf", "asdf", "testbotB");
	$testResults = array();
	$scenarios = scandir(dirname(__FILE__) . "/data");
	//iterate through subdirectories - one per test scenario row.
	foreach($scenarios as $rowIndex => $row) {
		if($rowIndex < 2) continue;
		$testResults[$rowIndex] = array();
		$tests = scandir(dirname(__FILE__) ."/data/$rowIndex");
		//iterate through subdirectories - one file per test
		foreach($tests as $testIndex => $test){
			if($testIndex < 2) continue;
			//create document for testbotA from start file.
			$doc = Document::CreateNewDocument("mergetest$rowIndex-$testIndex");
			$doc->renameClass("MERGETEST");
			$botAversion = Version::CreateNewVersion($doc->docId, $testbotA->userId);
			$botAversion->publish(file_get_contents(dirname(__FILE__). "/data/$rowIndex/$testIndex/original.html"));
			//branch off testbotA's document for testbotB
			$botBversion = Version::CreateNewVersion($doc->docId, $testbotB->userId, $botAversion->versionId);
			//write document for testbotB
			$botBversion->publish(file_get_contents(dirname(__FILE__)."/data/$rowIndex/$testIndex/branch.html"));
			if(file_exists(dirname(__FILE__)."/data/$rowIndex/$testIndex/modified.html")) {
				$botAversion->publish(file_get_contents(dirname(__FILE__)."/data/$rowIndex/$testIndex/modified.html"));
			}
			//create diffArray, select on index of this test
			$diffArray = array();
			require(dirname(__FILE__). "/data/$rowIndex/$testIndex/diff.php");
			//merge and compare output
			switch($testIndex) {
				case 2:
				case 3:
				case 6:
				case 7:
					$botAversion->diff($botBversion);
					$botAversion->merge($botBversion, $diffArray);
					$outputFile = $botAversion->getRepoLocation() . "/document.html";
					break;
				default:
					$botBversion->diff($botAversion);
					$botBversion->merge($botAversion, $diffArray);
					$outputFile = $botBversion->getRepoLocation() . "/document.html";
			}
			$benchmarkFile = dirname(__FILE__) . "/data/$rowIndex/$testIndex/merge.html";
			$diffOutput = runCommand("diff $benchmarkFile $outputFile");
			if($diffOutput) {
				echo "\ntest failed!\n";
				print_r($diffOutput);
			}
			$testResults[$rowIndex][$testIndex] = $diffOutput ? "fail" : "pass";
		}
	}
	$resultFilename = dirname(__FILE__) . "/results.csv";
	$resultFile = fopen($resultFilename, "w+");
	foreach($testResults as $row) {
		$line = implode($row, ",");
		fwrite($resultFile, "$line\n");
	}
	
/*	$doc = testCreateDocument();
	
	$docId = $doc->docId; 
	testCreateVersion($docId, $version, $version2);
			
	//testDiff($docId);
	$version->diff($version2);
	$diff1 = new Diff($docId,1,2,UserDiffAction::accepted, DiffType::mod,0);
	$diff2 = new Diff($docId,1,2,UserDiffAction::rejected, DiffType::mod,1);
	$diffArray = array($diff1, $diff2);
	$version->merge($version2, $diffArray);		
	
	//$versions = $doc->getAllVersions();
	//print_r($versions);
*/
?>
