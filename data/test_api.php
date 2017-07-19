<?php
include("API_Call.php");

$caller = new CallAPI("secrets.json");
$caller->getMovies("groundhog");
foreach ($caller->movies as $movie) {
	        echo $movie->title, " ", $movie->overview,PHP_EOL;
}
?>
