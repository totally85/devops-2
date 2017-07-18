<?php
function call_API($search) {
        $auth_data = file_get_contents("secrets.json", true);
	$auth = json_decode($auth_data);
	$API_Key = $auth->{'moviedb-api-key'};

	//TODO Search to sanitized query string
	$sanitized_query = $search;

	$query = "https://api.themoviedb.org/3/search/keyword?query={$sanitized_query}&api_key={$API_Key}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	//TODO Is there an error to catch from curl_exec?
        $output = curl_exec($ch);
	//TODO Handle bad status
        $output = json_decode($output);
	$results = $output->results;

	foreach ($results as $result)
	{
		echo $result->id, " ", $result->name, PHP_EOL;
	}
        curl_close($ch);
}
?>
