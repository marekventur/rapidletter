<?php 
	/* Erzeugt einen Auflistung aller Einträge eines Benutzeradressbuches */

	/* Ist der User überhaupt eingeloggt? */
	if ($user_is_logged_in) {
		/* "Wollen sie wirklich löschen"-Nachfrage einbauen */
		$script = "$(document).ready(function() { 
			init_delete_confirm('Löschen');		
		});";
		
		/* Eintrag löschen */
		if (isset($_GET['delete'])) {
			$sql = "DELETE FROM empfaenger WHERE benutzer = ".$user['id']. " AND id=".($_GET['delete']*1)." LIMIT 1;";
			mysql_query($sql) or die(mysql_error());
		}	
?>
	
<a target="_blank" href="<?=createURL("adressbucheintrag", "id=new")?>" class="iframe orange_button">Neuen Eintrag anlegen</a>

<div id="adressbuch_content">
<?php 
	$sql = "SELECT id, firmenname, vorname, nachname, show_normal, full FROM empfaenger WHERE benutzer = ".$user['id']." ORDER BY nachname, vorname ASC";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($res)) {
	
		/* Eine aussagekräftige Zeile für den Eintrag erstellen */		
		$line = $row['vorname'];
		if ($row['nachname']!='') {
			if ($line != '') $line .= " ";
			$line .= $row['nachname'];
		}
			
		if ($row['firmenname']!='') {
			if ($line != '') $line .= ", ";
			$line .= $row['firmenname'];
		}	
		
		if ($row['show_normal'] == '0') {
			$lines = explode("\n", $row['full']);
			$line = $lines[0];
		}
		
		echo '<div class="addressbuch_line">
			<a target="_blank" class="iframe" href="'.createURL("adressbucheintrag", "id=".$row['id']).'">'.$line.'</a>';
		
		/* Falls die Seite von designer3adressbuch aufgerufen wird, erzuge einen "Adresse einfügen"-Link */
		if (isset($use_in_designer)) {
			echo ' <a href="'.createURL($this_page, "use=".$row['id']).'" class="use_adress ">Adresse verwenden</a>';
		}
		
		/* Löschen-Link */
		echo ' <a href="'.createURL($this_page, "delete=".$row['id']).'" class="delete_confirm">Löschen</a>';
			
		echo '</div>';
	}
?>
</div>

<?php 	
	}
?>