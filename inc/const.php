<?php 
	/* Database */
	define("DB_CONNECTION_STRING", "host=localhost port=5432 dbname=rapidletter user=rapidletter password=rapidletter");
	
	/* Server */
	define("URL", $_SERVER["URL"]);
	
	/* Path */
	define("PATH" ,"/var/www/rapidletter/");
	
	require('letter_fields.php');
?>
