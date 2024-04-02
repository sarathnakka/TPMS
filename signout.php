<?php
/**
 * User Login System
 * @author Resalat Haque
 * @link http://www.w3bees.com
 */
 
require_once('function.php');
session_start();

if(session_destroy())
	redirect('index.php');
	exit;
?>