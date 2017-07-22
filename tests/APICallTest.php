<?php
include("resources/library/APICall.php");

use PHPUnit\Framework\TestCase;

final class APICallTest extends TestCase
{
	//TODO Fragile. What if movies change?
	public function testCanGetGroundhogMovies() {
		$caller = new APICall("secrets.json");
		$caller->getMovies("groundhog");

		$this->assertcount(2, $caller->movies);
		$movies = $caller->movies;
		// Assume they always come ordered by id
		$this->assertEquals($movies[0]->title, "Groundhog Day");
		$this->assertEquals($movies[1]->title, "The Groundhogs");
	}
}
?>
