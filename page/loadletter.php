<?php 
	/* Läd einen Brief aus der Datenbank */	

	$title = "Brief laden";
		
	if (!isset($_GET['id'])) {
		die('Keine ID gegeben.');
	}
	
	$id = $_GET['id']*1;
	
	if (loadletter($id)) {
		header("Location: ".createURL("designer1")); 
		exit;
	}
	else
	{
		echo "Brief konnte nicht geladen werden.";
	}
?>