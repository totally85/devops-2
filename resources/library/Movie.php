<?php
class Movie
{
	public $title;
	public $overview;
	function __construct($search_result) {
		$this->title = $search_result->title;	
		$this->overview = $search_result->overview;	
	}
}
?>
