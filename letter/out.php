<?php 
	/* Dieses Script erzeugt einen Brief und gibt ihn als PDF oder PNG aus */
	
	require_once("../inc/const.php");
	require_once("../inc/init.php");
	require_once("../inc/functions.php");
	require_once("../inc/session.php");
	
	require_once(PATH."letter/letter_".getSessionVarEmpty('design').".php");

	$letter = new Letter();
	
	initLetterFromSession($letter);
	
	
	if ($_GET['type'] == 'png')
		$letter->OutputImage(1, 296, 420);
	if ($_GET['type'] == 'pdf')
		$letter->Show(); 
	if ($_GET['type'] == 'pdfs')
		$letter->Save(); /* Ein PDF mit der HTTP-Header-Anweisung die Datei zu speichern und nicht anzuzeigen*/
	
		
?>