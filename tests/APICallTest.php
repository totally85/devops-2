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
	}
}
?>
