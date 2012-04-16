<?php 
	/* Diese Datei startet einen komprimierte Datenausgabe */

	function compress_output_option($output)
	{
	    /* Inhalt komprimieren */
	    $compressed_out = gzencode($output);
	
	    /* Sollte der Inhalt kleiner <1000 Byte sein nicht komprimieren (Lohnt nicht den Overhead) */
	    if(strlen($output) >= 1000)
	    {
	        header("Content-Encoding: gzip");
	        return $compressed_out;
	    }
	    else
	    {
	        error_log('compression.php Standard Output.');
	        return $output;
	    }
	}
	
	
	/* Akzeptiert der Browser GZip? */
	if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip'))
		ob_start("compress_output_option");
	

?>