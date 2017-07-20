<?php
include("resources/library/APICall.php");
include("resources/library/MCAPI.php");

$search = "groundhog";
$api = new APICall("secrets.json");
$mc = new MCAPI($api, $search, 3);
$num_results = rand(0, 10);
$movies = $mc->generateMovies($num_results);

if (count(movies) > 0) {
	echo '<ol>';
	foreach ($movies as $movie) {
		echo '<li>';
		echo '<span class="title">' . $movie->title . '</span>';
		echo '<span class="overview">' . $movie->overview . '</span>';
		echo '</li>';
	}
	echo '</ol>';
} else {
	echo '<span id="movie-error">Could not find any movies for ' . $search . '.</span>';
}
?>
