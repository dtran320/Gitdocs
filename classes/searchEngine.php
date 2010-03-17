<?php

/* ----------------------------------------------------------------------------
 * SearchEngine class
 * 
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */
require_once(dirname(__FILE__) . "/../config-solr.php");
require_once(dirname(__FILE__) . "/../lib/utils.php");
require_once(dirname(__FILE__) . "/version.php");
require_once(dirname(__FILE__) . "/user.php");

class SearchEngine {

	private $options;
	private $client;
	public function __construct() {
		$this->options = array
		(
    			'hostname' => SOLR_SERVER_HOSTNAME,
    			'login'    => SOLR_SERVER_USERNAME,
    			'password' => SOLR_SERVER_PASSWORD,
    			'port'     => SOLR_SERVER_PORT,
		);

		$this->client = new SolrClient($this->options);
	}	
	
	public static function StartSearchEngine() {
		global $SOLR_INSTALL_PATH;
		runCommand("java -jar $SOLR_INSTALL_PATH/example/start.jar");	
	}

	/*Updates (or adds!) a version to the index. 
	Note that you will not see changes in search results until you call updateIndex()*/	
	public function updateVersion($v) {
		$solrDoc = new SolrInputDocument();
		$solrDoc->addField('id', $v->versionId);
		$solrDoc->addField('text',$v->getDocFromDisk());
		$solrDoc->addField('name',$v->getName());
		$solrDoc->addField('userId', $v->getUserId());
		$solrDoc->addField('docId',$v->getDocId());
		$solrDoc->addField('last_modified',$v->getVersionSaveTime());
		$solrDoc->addField('docName', $v->getDocument()->name);
		$userInfo = User::GetUserInfoForId($v->getUserId());	
		$solrDoc->addField('userName',$userInfo["username"]);
		$solrDoc->addFIeld('iconPtr',getIconPtr($v->getUserId()));
		$solrDoc->addField('link', "viewer.php?v_id=".$v->versionId);

		$updateResponse = $this->client->addDocument($solrDoc);
		if(DEBUG)print_r($updateResponse->getResponse());
	}	

	/*runs a query, returns a SolrResponse object*/	
	public function runQuery($queryString, $start = 0) {
		$query = new SolrQuery();
		$query->setQuery($queryString);
		$query->setStart($start);
		$query->setRows(50);
		$queryResponse = $this->client->query($query);
		if(DEBUG)print_r($queryResponse->getResponse());
		return $queryResponse->getResponse();
	}

	/*Updates the index with all changes pushed to updateVersion
	 This is an expensive operation, if traffic is signfiicant this should be moved to a cron job*/	
	public function updateIndex(){
		$this->client->commit();
		$this->client->optimize();
	}

	public function indexAll(){
		$versionList = Version::getRecentGlobalVersionsClean();
		$versionCount = count($versionList);
		$lastPercent = 0;
		foreach($versionList as $k => $v){
			$version = new Version(0,0,0,0,$v["vId"]);
			$this->updateVersion($version);
			if(($percentDone= (int)($k/$versionCount*100)) != $lastPercent) {echo "$percentDone%\n"; $lastPercent = $percentDone;}
		} 	
		$this->updateIndex();
	}
}
