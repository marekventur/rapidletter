<?php 
	/* Diese Datei richtet die Session ein und ließt -falls vorhanden- den User aus der Datenbank */

	/* Session */
	session_start();
	
	/* User */
	if (isset($_SESSION['user'])) {
		$user_is_logged_in = true;
		$sql = "SELECT * from benutzer where id='".mysql_real_escape_string($_SESSION['user'])."' LIMIT 1;";
		$res = mysql_query($sql) or die(mysql_error());
		if(!$user = mysql_fetch_array($res)) {
			unset($_SESSION['user']);
			$user_is_logged_in = false;
		}
	}
	else
	{
		$user_is_logged_in = false;
	}

	
	
?>
