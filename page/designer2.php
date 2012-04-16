<?php 
	$title = "Schritt 2 von 5";

	/* Brief ggf. in der Session erzeugen */
	initLetter();
	
	/* Aktuellen Schritt in der Session festhalten */
	$_SESSION['designer_nr'] = max(2, $_SESSION['designer_nr']);
	
	/* POST-Daten verarbeiten */
	designer_handle_post(2);	
	
	/* Javascript initialisieren */
	$script = "$(document).ready(function() {
		$('.refresh_button').click(function(){return refresh_preview(2);});
		show_bzz();
		$('#bzz_use').change(show_bzz);
	});";
	
	/* Bei "Weiter" zur nächsten Seite weiterleiten */
	if (isset($_POST['do_next'])) {
		header("Location: ".createURL("designer3")); 
		exit;
	}
	
	/* Bei "Zurück" zur vorherigen Seite weiterleiten */
	if (isset($_POST['do_prev'])) {
		header("Location: ".createURL("designer1")); 
		exit;
	}
?>

<?php /* 2. Schritt im Brief erzeugen */ ?>
	
<h1>Brief erzeugen</h1>

<form enctype="multipart/form-data" class="designer_form" action="<?php echo createURL("designer2"); ?>" method="post">


<div class="designer_left">
	<a href="letter.pdf" class="iframe" target="_blank"><img class="letter_preview_297" id="letter_preview" src="/letter.png" alt="Briefvorschau" /></a>
	<input type="submit" name="do_refresh" value="Vorschau aktualisieren" class="refresh_button icon_button icon_button_reload letter_preview_button" />	
</div>

<?php /* Eingabe der Absenderdaten */?>

<div class="designer_right">
	<h2><span class="gray">Schritt 2/5 : </span> Absender</h2>
	
	<?php if (getSessionVarEmpty('letter_type') != 'private') {  ?>
		<div class="designer_form_row use_hover" >
			<label for="absender_firmenname">Firmenname</label>
			<input type="text" name="absender_firmenname" id="absender_firmenname" value="<?=$_SESSION['absender_firmenname']?>" />
			<div class="designer_form_tooltip">
				Falls Sie den Brief im Namen einer Firma schreiben, sollten Sie hier den Firmennamen eintragen.<br />
				<span class="gray">Dieses Feld ist optional.</span>
			</div>
		</div> 
	<?php } ?> 
	
		<div class="designer_form_row use_hover">
			<label for="absender_anrede">Anrede</label>
			<input type="text" name="absender_anrede" id="absender_anrede" value="<?=$_SESSION['absender_anrede']?>" />
			<div class="designer_form_tooltip">
				Sie können hier eine Anrede für die Absenderangaben auswählen. <br />
				<span class="gray">Um den Platzbedarf bei einzeiligen Absenderfeldern (wie bei Fensterbriefumschlägen) 
				möglichst gering zu halten, wird auf diese Angabe oft verzichtet. Dieses Feld ist optional.</span>
			</div>
		</div> 

		<div class="designer_form_row use_hover">
			<label for="absender_vorname">Vorname</label>
			<input type="text" name="absender_vorname" id="absender_vorname" value="<?=$_SESSION['absender_vorname']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihren Vornamen ein. Falls Sie einen Firmennamen verwendet haben, können Sie dieses Feld leer lassen.<br />
				<span class="gray">Dieses Feld ist optional.</span>
			</div>
		</div>
		 
		<div class="designer_form_row use_hover">
			<label for="absender_nachname">Nachname</label>
			<input type="text" name="absender_nachname" id="absender_nachname" value="<?=$_SESSION['absender_nachname']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihren Nachnamen ein. Falls Sie einen Firmennamen verwendet haben, können Sie dieses Feld leer lassen.<br />
				<span class="gray">Dieses Feld ist optional.</span>
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="absender_strasse">Straße / Postfach (*)</label>
			<input type="text" name="absender_strasse" id="absender_strasse" value="<?=$_SESSION['absender_strasse']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie in dieses Feld Ihre Straße oder Ihr Postfach ein. <br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="absender_hausnummer">Hausnummer</label>
			<input type="text" name="absender_hausnummer" id="absender_hausnummer" value="<?=$_SESSION['absender_hausnummer']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihre Hausnummer ein. Bei Angabe eines Postfachs lassen Sie dieses Feld leer.<br /> 
				<span class="gray">Dieses Feld ist optional.</span>
			</div>
		</div> 

		<div class="designer_form_row use_hover">
			<label for="absender_plz">Postleitzahl (*)</label>
			<input type="text" name="absender_plz" id="absender_plz" value="<?=$_SESSION['absender_plz']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihre Postleitzahl ein.<br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="absender_ort">Ort / Stadt (*)</label>
			<input type="text" name="absender_ort" id="absender_ort" value="<?=$_SESSION['absender_ort']?>" />
			<div class="designer_form_tooltip">
				Tragen Sie hier Ihren Ort ein.<br />
				<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
			</div>
		</div> 
			
		<?php if (getSessionVarEmpty('letter_type') == 'private') { echo '<div style="display:none;">'; } ?>

		<?php /* Auswahl, ob Bezugszeile verwendet werden soll oder nicht */ ?>
		<?php /* Wenn ja, können die entsprechenden Eingaben gemacht werden */ ?>
		
			<h3>Bezugszeichenzeile oder Informationsblock</h3>
			 
			<div class="designer_form_row use_hover">
				<label for="bzz_use">Ansicht</label>
				<select name="bzz_use" id="bzz_use">
					<option value="no" <?=(($_SESSION['bzz_use']=="no")?"selected=\"selected\"":"")?>>nicht anzeigen</option>
					<option value="bzz" <?=(($_SESSION['bzz_use']=="bzz")?"selected=\"selected\"":"")?>>Bezugszeichenzeile</option>
					<!-- 
						<option value="inf">Als Informationsblock</option>
					-->	
				</select>
				<div class="designer_form_tooltip">
					Wählen Sie, ob eine Bezugszeile (Ihr Zeichen, Unser Zeichen, usw.) verwendet werden soll oder nicht.
				</div>
			</div> 	 
			 
			<div class="designer_form_row use_hover">
				<label for="bzz_ihrzeichen">Ihr Zeichen</label>
				<input type="text" name="bzz_ihrzeichen" id="bzz_ihrzeichen" value="<?=$_SESSION['bzz_ihrzeichen']?>" />
				<div class="designer_form_tooltip">
					"Ihr Zeichen, Ihre Nachricht".<br />
				<span class="gray">Entfällt, wenn kein Brief vorausging.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_unserzeichen">Unser Zeichen</label>
				<input type="text" name="bzz_unserzeichen" id="bzz_unserzeichen" value="<?=$_SESSION['bzz_unserzeichen']?>" />
				<div class="designer_form_tooltip">
					"Unser Zeichen, unsere Nachricht". <br />
				<span class="gray">Entfällt, wenn kein Brief vorausging.</span>
				</div>
			</div> 	
	
			<div class="designer_form_row use_hover">
				<label for="bzz_name">Name</label>
				<input type="text" name="bzz_name" id="bzz_name" value="<?=$_SESSION['bzz_name']?>" />
				<div class="designer_form_tooltip">
					Name des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn kein Ansprechpartner angegeben werden kann.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_telefon">Telefon</label>
				<input type="text" name="bzz_telefon" id="bzz_telefon" value="<?=$_SESSION['bzz_telefon']?>" />
				<div class="designer_form_tooltip">
					Durchwahl des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn keine Telefonnummer angegeben werden kann.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_fax">Fax</label>
				<input type="text" name="bzz_fax" id="bzz_fax" value="<?=$_SESSION['bzz_fax']?>" />
				<div class="designer_form_tooltip">
					Telefax-Anschluß des Ansprechpartners. <br />
				<span class="gray">Entfällt, wenn kein Telefax-Anschluß angegeben werden kann.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_email">E-Mail</label>
				<input type="text" name="bzz_email" id="bzz_email" value="<?=$_SESSION['bzz_email']?>" />
				<div class="designer_form_tooltip">
					 	E-Mail-Adresse des Ansprechpartners <br />
				<span class="gray">Entfällt, wenn keine E-Mail-Adresse angegeben werden kann.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_internet">Internetadresse</label>
				<input type="text" name="bzz_internet" id="bzz_internet" value="<?=$_SESSION['bzz_internet']?>" />
				<div class="designer_form_tooltip">
					 	Internet-Adresse des Unternehmens <br />
				<span class="gray">Entfällt, wenn keine Internet-Adresse angegeben werden kann.</span>
				</div>
			</div> 	
			
			<div class="designer_form_row use_hover">
				<label for="bzz_datum">Datum</label>
				<input type="text" name="bzz_datum" id="bzz_datum" value="<?=$_SESSION['bzz_datum']?>" />
				<div class="designer_form_tooltip">
					Das aktuelle Datum wird von uns standardmäßig vorausgefüllt.  <br />
					<span class="gray">Möchten Sie ein anderes Datum verwenden, können Sie hier eintragen.</span>
				</div>
			</div>
			
			<?php /* Geschäftsangaben können eingegeben werden, wenn benötigt */ ?>
					
			<h3>Geschäftsangaben</h3> 	
			<!--  
			Siehe <a href="http://www.business-wissen.de/?id=3883">http://www.business-wissen.de/?id=3883</a>
			-->
			<div class="designer_form_row use_hover designer_form_row_tall">
				<textarea name="ga1" id="ga1" class="full_width"><?=$_SESSION['ga1']?></textarea>
				<div class="designer_form_tooltip">
					Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen. 
				Geschäftsbriefe müssen die gesetzlich geforderten Pflichtangaben entsprechend der jeweiligen Gesellschaftsform führen. 
				Informieren Sie sich vorab, welche Vorgaben für Sie gelten. 
					<span class="gray">Ihre Angaben werden in der Fußzeile des Dokuments angezeigt.</span>
				</div>
			</div>
			
			<div class="designer_form_row use_hover designer_form_row_tall">
				<textarea name="ga2" id="ga2" class="full_width"><?=$_SESSION['ga2']?></textarea>
				<div class="designer_form_tooltip">
					Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen.
				</div>
			</div>
			
			<div class="designer_form_row use_hover designer_form_row_tall">
				<textarea name="ga3" id="ga3" class="full_width"><?=$_SESSION['ga3']?></textarea>
				<div class="designer_form_tooltip">
					Sie können verschiedene Versionen Ihrer Geschäftsangaben eingeben und je nach Bedarf eine Angabe auswählen.
				</div>
			</div>
			
		<?php if (getSessionVarEmpty('letter_type') == 'private') { echo '</div>'; } ?>
		
		<?php /* Benutzer kann entweder weiter oder zurück drücken */ ?>
		
		<input type="submit" class="button_prev orange_button" name="do_prev" value="&laquo; Zurück" />
		<input type="submit" class="button_next orange_button" name="do_next" value="Weiter &raquo;" />
	
</div>

</form>

<div class="designer_clear"></div>