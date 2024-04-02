<?php
	// Database Connection
	include('connection.php');
	
	// Calendar Class
	include('calendar.php');
	
	// Search
	if(isset($_POST['search']) && strlen($_POST['search']) > 0)
	{
		$_SESSION['condition'] = " title OR description LIKE '%".$_POST['search']."%'";	
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE, $_SESSION['condition']);
	} elseif(isset($_POST['search']) && strlen($_POST['search']) == 0) {
		$_SESSION['condition'] = false;
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE);
	} elseif(isset($_SESSION['condition']) && strlen($_SESSION['condition']) !== 0) {
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE, $_SESSION['condition']);
	} else {
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE);		
	}
	
?>