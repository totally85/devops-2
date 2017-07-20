<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
include_once("Movie.php");

class MC
{
	function __construct($title_corpus, $overview_corpus, $k) {
		$this->tc = $title_corpus;
		$this->oc = $overview_corpus;

		//TODO Handle case where $k > length of either corpus
		$this->title_chain = new MarkovPHP\WordChain($title_corpus, $k);
		$this->overview_chain = new MarkovPHP\WordChain($overview_corpus, $k);
	}

	public function generateTitle($n) {
		return $this->title_chain->generate($n);
	}

	public function generateOverview($n) {
		return $this->overview_chain->generate($n);
	}

	public function generateMovie() {
		$m = rand(1, 8);
		$n = rand(20, 40);
		return new Movie($this->generateTitle($m), $this->generateOverview($n));
	}

	public function generateMovies($n) {
		for ($i = 0; $i <= $n; $i++) {
			$a[] = $this->generateMovie();
		}
		return $a;
	}
}
?>
