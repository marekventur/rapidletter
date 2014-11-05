<?php 
	/* Database */
	define("DB_CONNECTION_STRING", "host=localhost port=5432 dbname=rapidletter user=rapidletter password=rapidletter");
	
	/* Server */
	define("URL", $_ENV["ROOT_URL"]);
	
	/* Path */
	define("PATH" ,"/app/");
	
	require('letter_fields.php');
?>
