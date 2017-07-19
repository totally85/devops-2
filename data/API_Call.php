<?php
class CallAPI
{
	public function loadSecrets() {
		$auth_data = file_get_contents("secrets.json", true);
		return json_decode($auth_data);
	}

	public function makeRequest($query) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//TODO Is there an error to catch from curl_exec?
		$output = curl_exec($ch);
		//TODO Handle bad status
		$json_output = json_decode($output);
		curl_close($ch);
		return $json_output;
	}
		
	public function getPageIds($search) {
		$auth = self::loadSecrets();
		$API_Key = $auth->{'moviedb-api-key'};

		//TODO Search to sanitized query string
		$sanitized_query = $search;

		$query = "https://api.themoviedb.org/3/search/keyword?query={$sanitized_query}&api_key={$API_Key}";
		$output = self::makeRequest($query);
		$results = $output->results;

		foreach ($results as $result)
		{
			echo $result->id, " ", $result->name, PHP_EOL;
		}
	}
}
?>
