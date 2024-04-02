<?php
	
	include('includes/loader.php');
	
	// set correct content-type-header
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: inline; filename=calendar.ics');

	echo preg_replace('#\[[^\]]+\]#', '', $calendar->icalExport_all());
	
?>