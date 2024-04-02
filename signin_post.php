<?php

require_once('function.php');
dbconnect();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (attempt($_POST['username'], $_POST['password'])) {
		redirect('home.php');
	}
	else {
		redirect('index.php?error=' . urlencode('Wrong username or password'));
	}
}

?>