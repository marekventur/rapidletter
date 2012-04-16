<?php 
	/* Über dieses Script wird jede Seite aufgerufen */
	
	require_once("inc/const.php");
	require_once("inc/init.php");
	require_once("inc/functions.php");
	require_once("inc/session.php");
	
	header('Content-Type: text/html; charset=UTF-8');
	
	/* Ist die Seite vorhanden? */
	$page = isset($_GET['p'])?$_GET['p']:'index';
	if (!file_exists("page/".$page.".php")) $page="404";
	$template = isset($_GET['t'])?$_GET['t']:'main';
	$title = "";
	$header = "";
	$footer = "";
	$script = "";
	
	/* Buffer anlegen */
	ob_start();
	/* Seite einfügen */
	include ("page/".$page.".php");
	/* Buffer leeren und auslesen */
	$content = ob_get_clean ();
	
	/* Passendes Template verwenden */
	include ("template/".$template.".php");
	

?>