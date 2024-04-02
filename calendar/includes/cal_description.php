<?php
	
	// Loader - class and connection
	include('loader.php');
	
	$content = $calendar->get_description($_POST['id']);
	
	if($content == true)
	{
		if(isset($_POST['mode']) && $_POST['mode'] == 'edit')
		{
			echo $content;	
		} else {
			echo $embed->oembed($formater->html_format($content));
		}
	} else {
		echo '';
	}
	
?>