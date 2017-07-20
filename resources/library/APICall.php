<?php
include_once("Movie.php");

class APICall
{
	private $API_Key;
	private $ch;
	public $movies;

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
	public function sanitizeQuery($query) {
		//TODO Sanitize query string
		return $query;
	}

	public function movieQuery($query) {
		$clean = $this->sanitizeQuery($query);
		$query = "https://api.themoviedb.org/3/search/movie?query={$clean}&api_key={$this->API_Key}";
		return $query;
	}

	public function getMovies($search) {
		$query = $this->movieQuery($search);
		$output = $this->makeRequest($query);
		$results = $output->results;

		$this->movies = array_map(function ($x) { return new Movie($x->title, $x->overview); }, $results);
		$this->createTitleCorpus();
		$this->createOverviewCorpus();
	}

	private function createTitleCorpus() {
		$titles = array_map(function ($x) { return $x->title; }, $this->movies);
		$this->title_corpus = implode(" ", $titles);
	}

	private function createOverviewCorpus() {
		$overviews = array_map(function ($x) { return $x->overview; }, $this->movies);
		$this->overview_corpus = implode(" ", $overviews);
	}
}
?>
