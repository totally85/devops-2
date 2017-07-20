<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
include_once("MC.php");

//TODO This class should probably inherit from MC
class MCAPI
{
	public $search;
	public $k;
	public $mc;

	function __construct($api, $search, $k) {
		$this->search = $search;
		$this->k = $k;
		$api->getMovies($search);

		$this->mc = new MC($api->title_corpus, $api->overview_corpus, $k);
	}

	public function generateTitle($n) {
		return $this->mc->generateTitle($n);
	}

	public function generateOverview($n) {
		return $this->mc->generateOverview($n);
	}

	public function generateMovie() {
		return $this->mc->generateMovie();
	}

	public function generateMovies($n) {
		return $this->mc->generateMovies($n);
	}
}
?>
