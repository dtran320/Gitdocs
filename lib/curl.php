<?php

class CurlResult {
	
	public $transferResult;
	public $info;
	
	function __construct() {
		$this->transferResult = "";
		$this->info = "";
	}
	
}

class Curl {

	private $cURL = 0;
	
	function __construct() {
		$this->cURL = curl_init();
		curl_setopt($this->cURL, CURLOPT_HEADER, false);
		curl_setopt($this->cURL, CURLOPT_RETURNTRANSFER, true);
		
		//Follow redirects
		//curl_setopt($this->cURL, CURLOPT_FOLLOWLOCATION, true);
		//curl_setopt($this->cURL, CURLOPT_MAXREDIRS, 5);
		
		//Allow redirects to https (such as http://bugzilla.com -> https://bugzilla.com)
		//curl_setopt($this->cURL, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($this->cURL, CURLOPT_SSL_VERIFYHOST, false);
	}
	
	function __destruct() {
		curl_close($this->cURL);
	}
	
	function getResultsForURL($url) {
		curl_setopt($this->cURL, CURLOPT_URL, $url);
		$curl_result = new CurlResult();
		$curl_result->transferResult = curl_exec($this->cURL);
		$curl_result->info = curl_getinfo($this->cURL, CURLINFO_HTTP_CODE);
		return $curl_result;
		
	}
	
	function setUserPwd($username, $password) {
		curl_setopt($this->cURL, CURLOPT_USERPWD, "$username:$password");
	}

}


?>
