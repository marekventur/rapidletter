<?php 
	/* Speicher die mit POST übergebenen Variablen und erzeuge einen MD5-Hash */	

	require_once("../inc/const.php");
	require_once("../inc/init.php");
	require_once("../inc/functions.php");
	require_once("../inc/session.php");
	
	initLetter();
	
	/* Ein paar Sonderfälle für Designer 1... */
	
	if (isset($_GET['design'])) {
		$_SESSION['design'] = $_GET['design'];
	}
	if (isset($_GET['logo']) && ($_GET['logo'] == "delete")) {
		$_SESSION['header'] = "";
		@unlink(PATH."uploads/logo/big_" . $_SESSION['uid'].".png");
		@unlink(PATH."uploads/logo/small_" . $_SESSION['uid'].".png");
	}
	
	
	/* ...ansonsten alles wie normal */
	if (isset($_GET['nr']))
		$designer_nr = $_GET['nr'];
	else
		die('No number given');
		
	/* POST-Daten verarbeiten */
	designer_handle_post($designer_nr);
	
	/* MD5-Hash über den POST-Array bilden */
	echo md5(print_r($_POST, true));
	
?>