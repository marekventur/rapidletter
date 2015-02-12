<?php 
	/* Upload static file to DB (overide!) */
	function static_upload($filename, $lifetime = NULL) {
		/* Delete if there is an existing Entry */
		$sql = "DELETE FROM static WHERE filename = '".mysql_real_escape_string($filename)."';";
		mysql_query($sql) or die(mysql_error());
		
		/* Load File */
		$filename_full = PATH.$filename;
		if (file_exists($filename_full)) {
			$fp     = fopen($filename_full, 'r');
			$size 	= filesize($filename_full);
			$data 	= fread($fp, $size);
			fclose($fp);	
		}
		else
			return false;
		
		/* Make sure "lifetime" is MySQL-safe */
		$lifetime_int = ($lifetime+0) * 1;	
			
		/* Create sql */
		$sql = "INSERT INTO 
					static (filename, lifetime, size, data) 
				VALUES ('".mysql_real_escape_string($filename)."', ".$lifetime_int.", ".$size.", '" .pg_escape_bytea($data) ."' )";

		mysql_query($sql) or die(mysql_error());
		
		return true;
	}
	
	/* Make sure that a specific file is available, otherwise download it */
	function static_exists($filename) {
		
		$filename_full = PATH.$filename;
		
		if (file_exists($filename_full)) 
			return true;
		else
		{
			$sql = "SELECT data FROM static WHERE filename = '".mysql_real_escape_string($filename)."';"; 
			$res = mysql_query($sql) or die(mysql_error());
			if(list($data) = mysql_fetch_array($res)){
				$fp = fopen($filename_full, 'w+') or die("can't open file");
				fwrite($fp, $data);
				fclose($fp);
				return true;
			}
		}
		return false;
	}

?>