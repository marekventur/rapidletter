<?php
	/* Diese Seite zeigt alle Briefe eines Benutzers an */

	$title = "Ihr Profil";
	
	/* Ist der Benutzer eingeloggt? */
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		/* Profil-Links einbinden */
		include ('components/profil_left.php');
		
		/* Lösch-Bestätigungs-Meldungen aktivieren */
		$script = "$(document).ready(function() { 
			init_delete_confirm('Löschen');		
		});";
		
		/* Brief löschen */
		if (isset($_GET['delete'])) {
			$sql = "DELETE FROM briefe WHERE id=".mysql_real_escape_string($_GET['delete'])." AND benutzer=".$user['id']." LIMIT 1;";
			mysql_query($sql) or die(mysql_error());
		}
	
?>

<div class="half_right">
	<h2>Ihre gespeicherten Briefe</h2>
		
		<ul class="letter_list">
		
		<?php 
			$sql = "SELECT ispublic, id, uid, empfaenger_vorname, empfaenger_nachname, empfaenger_firmenname, empfaenger_show_normal, empfaenger_full, betreff FROM briefe WHERE benutzer = ".$user['id'].";";
			$res = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_array($res)){
				/* Verständliche Empäfnger-Zeile generieren */
				$empfaenger = $row['empfaenger_vorname'];
				if ($row['empfaenger_nachname']!='') {
					if ($empfaenger != '') $empfaenger .= " ";
					$empfaenger .= $row['empfaenger_nachname'];
				}
					
				if ($row['empfaenger_firmenname']!='') {
					if ($empfaenger != '') $empfaenger .= ", ";
					$empfaenger .= $row['empfaenger_firmenname'];
				}	
				
				if ($row['empfaenger_show_normal'] == '0') {
					$lines = explode("\n", $row['empfaenger_full']);
					$empfaenger = $lines[0];
				}
				
				if ($empfaenger == '') $empfaenger = "Nicht definiert";
				
				echo '
					<li>
						<div class="icon icon_'.(($row['ispublic']=='0')?'letter':'social').'"></div>
						<div class="letter_list_line">
							<span class="gray">An: </span>'.$empfaenger.'<br />
						</div>
						<div class="letter_list_line">
							<span class="gray">Betreff: </span>'.$row['betreff'].'<br />
						</div>
						<div class="letter_list_line">
							'.(($row['ispublic']=='0')?'':'<a href="'.createURL("brief", "id=".$row['uid']).'">Link</a> |').'
							<a href="'.createURL("loadletter", "id=".$row['id']).'">Als neuen Brief öffnen</a> | 
							<a class="delete_confirm" href="'.createURL("profil", "delete=".$row['id']).'">Löschen</a>
						</div>
					</li>';
			}
		
		?>
	
		</ul>
	

</div>
<div class="half_clear"></div> 
<?php 
	}
?>