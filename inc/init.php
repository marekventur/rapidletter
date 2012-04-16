<?php 
	/* Database */
	mysql_connect(DB_HOST, DB_USER, DB_PW) or die ('Error connecting to mysql');
	mysql_select_db(DB_DATABASE) or die ('Error opening db');
	mysql_set_charset('utf8');	
?>