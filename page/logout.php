<?php 
	/* Dieses Script loggt den Benutzer aus und schickt ihn zurück zur letzten Seite */
	unset ($_SESSION['user']);

	header("Location: ".$_SERVER['HTTP_REFERER']); 
	exit;
?>