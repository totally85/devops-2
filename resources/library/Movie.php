<?php
class Movie
{
	public $title;
	public $overview;
	function __construct($title, $overview) {
		$this->title = $title;	
		$this->overview = $overview;	
	}
}
?>
