<?php

	// Loader - class and connection
	include('loader.php');
	
	// Catch start, end and id from javascript
	$id = $_POST['id'];
	$event_title = $_POST['title'];
	$event_description = $_POST['description'];
	
	if(isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		$url = 'false';	
	}
	
	if($calendar->updates($id, $event_title, $event_description, $url) === true) {
		return true;	
	} else {
		return false;	
	}

?>