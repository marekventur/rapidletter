<?php
	/* Hier kann der Benutzer seine Absenderdaten verwalten */
	$title = "Ihr Profil";
	
	
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		include ('components/profil_left.php');
		
		if (isset($_POST['submit'])) {
			$sql = "UPDATE  
						benutzer 
					SET  
						firmenname =  	'".mysql_real_escape_string($_POST['firmenname'])."',
						anrede =  		'".mysql_real_escape_string($_POST['anrede'])."',
						vorname =  		'".mysql_real_escape_string($_POST['vorname'])."',
						nachname =  	'".mysql_real_escape_string($_POST['nachname'])."',
						strasse =  		'".mysql_real_escape_string($_POST['strasse'])."',
						hausnummer =  	'".mysql_real_escape_string($_POST['hausnummer'])."',
						plz =  			'".mysql_real_escape_string($_POST['plz'])."',
						ort =  			'".mysql_real_escape_string($_POST['ort'])."',
						use_bzz =  		'".mysql_real_escape_string($_POST['use_bzz'])."',
						name =  		'".mysql_real_escape_string($_POST['name'])."',					
						telefon =  		'".mysql_real_escape_string($_POST['telefon'])."',
						fax =  			'".mysql_real_escape_string($_POST['fax'])."',
						internet =  	'".mysql_real_escape_string($_POST['internet'])."',
						ga1 =  			'".mysql_real_escape_string($_POST['ga1'])."',
						ga2 =  			'".mysql_real_escape_string($_POST['ga2'])."',
						ga3 =  			'".mysql_real_escape_string($_POST['ga3'])."'
					WHERE  
						id = ".$user['id'].";";
			mysql_query($sql) or die(mysql_error());
			
			$sql = "SELECT * from benutzer where id='".mysql_real_escape_string($_SESSION['user'])."' LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			if(!$user = mysql_fetch_array($res)) {
				unset($_SESSION['user']);
				$user_is_logged_in = false;
			}
			
			
		}
		
		$script = "$(document).ready(function() {
					
					show_bzz_profil();
					$('#use_bzz').change(show_bzz_profil);
				});";
	
?>

<div class="half_right">
	<h2>Ihre Absenderdaten</h2>
	
	<form action="<?php echo createURL("profilabsender"); ?>" method="post">
	
		<div class="designer_form_row use_hover">
			<label for="firmenname">Firmenname</label>
			<input type="text" name="firmenname" id="firmenname" value="<?=$user['firmenname']?>" />
			<div class="designer_form_tooltip">
				Falls Sie den Brief im Namen einer Firma schreiben, sollten Sie hier den Firmennamen eintragen. 
				<span class="gray">Anderenfalls tragen Sie bitte Ihren Vor- und Nachnamen in die entsprechenden Felder.</span> <br />
			</div>
		</div> 

		<div class="designer_form_row use_hover">
			<label for="anrede">Anrede</label>
			<input type="text" name="anrede" id="anrede" value="<?=$user['anrede']?>" />
			<div class="designer_form_tooltip">
				Sie können hier eine Anrede für die Absenderangaben auswählen. <br />
				<span class="gray">Um den Platzbedarf bei einzeiligen Absenderfeldern (wie bei Fensterbriefumschlägen) 
				möglichst gering zu halten, wird oft auf diese Angabe verzichtet.</span>
			</div>
		</div> 

		<div class="designer_form_row use_hover">
			<label for="vorname">Vorname</label>
			<input type="text" name="vorname" id="vorname" value="<?=$user['vorname']?>" />
			<div class="designer_form_tooltip">
			Tragen Sie hier Ihren Vornamen ein. Falls Sie einen Firmennamen verwendet haben, können Sie dieses Feld leer lassen.<br />
			</div>
		</div>
		 
		<div class="designer_form_row use_hover">
			<label for="nachname">Nachname</label>
			<input type="text" name="nachname" id="nachname" value="<?=$user['nachname']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihren Nachnamen ein. Falls Sie einen Firmennamen verwendet haben, können Sie dieses Feld leer lassen.<br />
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="strasse">Straße / Postfach (*)</label>
			<input type="text" name="strasse" id="strasse" value="<?=$user['strasse']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie in dieses Feld Ihre Straße oder Ihr Postfach ein. <br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="hausnummer">Hausnummer</label>
			<input type="text" name="hausnummer" id="hausnummer" value="<?=$user['hausnummer']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihre Hausnummer ein. Bei Angabe eines Postfachs lassen Sie dieses Feld leer.<br /> 
			</div>
		</div> 

		<div class="designer_form_row use_hover">
			<label for="plz">Postleitzahl (*)</label>
			<input type="text" name="plz" id="plz" value="<?=$user['plz']?>" />
			<div class="designer_form_tooltip">
					Tragen Sie hier Ihre Postleitzahl ein.<br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="ort">Ort / Stadt (*)</label>
			<input type="text" name="ort" id="ort" value="<?=$user['ort']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihren Ort ein.<br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
			

		<h3>Bezugszeichenzeile oder Informationsblock</h3>
		 
		<div class="designer_form_row use_hover">
			<label for="use_bzz">Ansicht</label>
			<select name="use_bzz" id="use_bzz">
				<option value="no" <?=(($user['use_bzz']=="no")?"selected=\"selected\"":"")?>>nicht anzeigen</option>
				<option value="bzz" <?=(($user['use_bzz']=="bzz")?"selected=\"selected\"":"")?>>Bezugszeichenzeile</option>
				<!-- 
					<option value="inf">Als Informationsblock</option>
				-->	
			</select>
			<div class="designer_form_tooltip">
				Wählen Sie, ob eine Bezugszeile (Ihr Zeichen, Unser Zeichen, usw.) verwendet werden soll oder nicht. 
			</div>
		</div> 	 

		<div class="designer_form_row use_hover">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="<?=$user['name']?>" />
			<div class="designer_form_tooltip">
				Name des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn kein Ansprechpartner angegeben werden kann.</span>
			</div>
		</div> 	
		
		<div class="designer_form_row use_hover">
			<label for="telefon">Telefon</label>
			<input type="text" name="telefon" id="telefon" value="<?=$user['telefon']?>" />
			<div class="designer_form_tooltip">
				Durchwahl des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn keine Telefonnummer angegeben werden kann.</span>
			</div>
		</div> 	
		
		<div class="designer_form_row use_hover">
			<label for="fax">Fax</label>
			<input type="text" name="fax" id="fax" value="<?=$user['fax']?>" />
			<div class="designer_form_tooltip">
				Telefax-Anschluß des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn kein Telefax-Anschluß angegeben werden kann.</span>
			</div>
		</div> 	
		
		<div class="designer_form_row use_hover">
			<label for="internet">Internetadresse</label>
			<input type="text" name="internet" id="internet" value="<?=$user['internet']?>" />
			<div class="designer_form_tooltip">
			Internet-Adresse des Unternehmens <br />
				<span class="gray">Entfällt, wenn keine Internet-Adresse angegeben werden kann.</span>
			</div>
		</div> 	
		
		
		<h3>Geschäftsangaben</h3> 	
		<!--  
		Siehe <a href="http://www.business-wissen.de/?id=3883">http://www.business-wissen.de/?id=3883</a>
		-->
		<div class="designer_form_row use_hover designer_form_row_tall">
			<textarea type="text" name="ga1" id="ga1" class="full_width"><?=$user['ga1']?></textarea>
			<div class="designer_form_tooltip">
				Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen. 
				Geschäftsbriefe müssen die gesetzlich geforderten Pflichtangaben entsprechend der jeweiligen Gesellschaftsform führen. 
				Informieren Sie sich vorab, welche Vorgaben für Sie gelten. 
					<span class="gray">Ihre Angaben werden in der Fußzeile des Dokuments angezeigt.</span>
			</div>
		</div>
		
		<div class="designer_form_row use_hover designer_form_row_tall">
			<textarea type="text" name="ga2" id="ga2" class="full_width"><?=$user['ga2']?></textarea>
			<div class="designer_form_tooltip">
				Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen.
			</div>
		</div>
		
		<div class="designer_form_row use_hover designer_form_row_tall">
			<textarea type="text" name="ga3" id="ga3" class="full_width"><?=$user['ga3']?></textarea>
			<div class="designer_form_tooltip">
				Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen.
			</div>
		</div>
		
		<input type="submit" name="submit" class="orange_button" value="Speichern &raquo;" />
	
	</form>

</div>
<div class="half_clear"></div> 
<?php } ?>