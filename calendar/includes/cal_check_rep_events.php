<?php
	
	// Loader - class and connection
	include('loader.php');
	
	$rep = $calendar->check_repetitive_events($_POST['id']);
	
	if($rep == true)
	{
		echo 'REP_FOUND';
	} else {
		echo 'REP_NOT_FOUND';
	}
	
?>