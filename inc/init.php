<?php 
	/* Database */
	if (pg_connect(DB_CONNECTION_STRING)) {
		error_log('Can not connect to psql: '. DB_CONNECTION_STRING);
		die ('Something went wrong :(');
	} 
?>