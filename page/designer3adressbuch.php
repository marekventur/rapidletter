<?php
	/* IFrame-Seite: Das Adressbuch des Benutzers */
	$title = "Ihr Adressbuch";
	$template ="plain";

	/* Ansicht des Adressbuchs */
	
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		$use_in_designer = true;
		$this_page = "designer3adressbuch";
		
		/* Adresse verwenden */
		if ((isset($_GET['use'])) && (isset($use_in_designer))) {
			$sql = "SELECT * FROM empfaenger WHERE benutzer = ".$user['id']." AND id=".mysql_real_escape_string($_GET['use'])." LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());
			if($row = mysql_fetch_array($res)) {
				$_SESSION['empfaenger_firmenname'] = $row['firmenname'];
				$_SESSION['empfaenger_anrede'] = $row['anrede'];
				$_SESSION['empfaenger_vorname'] = $row['vorname'];
				$_SESSION['empfaenger_nachname'] = $row['nachname'];
				$_SESSION['empfaenger_strasse'] = $row['strasse'];
				$_SESSION['empfaenger_hausnummer'] = $row['hausnummer'];
				$_SESSION['empfaenger_plz'] = $row['plz'];
				$_SESSION['empfaenger_ort'] = $row['ort'];
				$_SESSION['empfaenger_show_normal'] = $row['show_normal'];
				$_SESSION['empfaenger_full'] = $row['full'];
				
				$script = "top.location = top.location;";
			} else {
				die ('Fehler.');
			}
			
		}
		else
		{	
		
		
?>

<div id="header">
	<h1>Ihr Adressbuch</h1>
</div>	

<div class="hspace20"></div>

<?php /* Bestandteile des Adressbuchs werden geladen */ ?>

<?php include "components/adressbuch.php"; ?>


<?php }} ?>