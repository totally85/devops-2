<?php
class CallAPI
{
	private $API_Key;
	private $ch;

	function __construct($secret_location) {
		$secrets = file_get_contents($secret_location, true);
		$secretsJSON = json_decode($secrets);
		$this->API_Key = $secretsJSON->{'moviedb-api-key'};
		$this->ch = curl_init();
	}

	function __destruct() {
		curl_close($this->ch);
	}

	public function makeRequest($query) {
		$ch = $this->ch;
		curl_setopt($ch, CURLOPT_URL, $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//TODO Is there an error to catch from curl_exec?
		$output = curl_exec($ch);
		//TODO Handle bad status
		$json_output = json_decode($output);
		return $json_output;
	}
		
	public function getPageIds($search) {
		//TODO Search to sanitized query string
		$sanitized_query = $search;

		$query = "https://api.themoviedb.org/3/search/keyword?query={$sanitized_query}&api_key={$this->API_Key}";
		$output = $this->makeRequest($query);
		$results = $output->results;

		return array_map(function ($x) { return $x->id; }, $results);
	}
}
?>
