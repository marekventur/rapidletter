<?php 
	$title = "Schritt 3 von 5";

	/* Brief ggf. in der Session erzeugen */
	initLetter();
	
	/* Aktuellen Schritt in der Session festhalten */	
	$_SESSION['designer_nr'] = max(3, $_SESSION['designer_nr']);
	
	/* Zwischen Full- und Normalansicht wechseln */
	if (isset($_GET['show'])) {
		if ($_GET['show'] == 'full') {
			$_SESSION['empfaenger_show_normal'] = '0';
			
			/* Full-Feld vorausfüllen */
			if (getSessionVarEmpty('empfaenger_full') == '') {
				$_SESSION['empfaenger_full'] = getSessionVarEmpty('empfaenger_firmenname'); 
				if ($_SESSION['empfaenger_full'] != '') $_SESSION['empfaenger_full'] .= "\n";
				if (getSessionVarEmpty('empfaenger_anrede') != '') $_SESSION['empfaenger_full'] .= getSessionVarEmpty('empfaenger_anrede').' ';
				if (getSessionVarEmpty('empfaenger_vorname') != '') $_SESSION['empfaenger_full'] .= getSessionVarEmpty('empfaenger_vorname').' ';
				if (getSessionVarEmpty('empfaenger_nachname') != '') $_SESSION['empfaenger_full'] .= getSessionVarEmpty('empfaenger_nachname');
				$_SESSION['empfaenger_full'] .= "\n".getSessionVarEmpty('empfaenger_strasse').' '.getSessionVarEmpty('empfaenger_hausnummer');
				$_SESSION['empfaenger_full'] .= "\n".getSessionVarEmpty('empfaenger_plz')." ".getSessionVarEmpty('empfaenger_ort');	
			}
			
		}
		else
		{
			$_SESSION['empfaenger_show_normal'] = '1';
		}
		letter_has_changed();
	}
	
	/* Texte und Links definieren */
	$show_normal = ($_SESSION['empfaenger_show_normal']==1);
	if ($show_normal) {
		$swap_link =  createURL("designer3", "show=full");
		$script = "designer3_swap(true);";
		$swap_text = 'Auf direkte Adressfeld-Eingabe umschalten';
	}
	else
	{
		$swap_link =  createURL("designer3", "show=normal");
		$script = "designer3_swap(false);";
		$swap_text = 'Auf normale Adressfeld-Eingabe umschalten';
	}
	
	
	/* POST-Daten verarbeiten */
	designer_handle_post(3);
	
	
	/* Javascript initialisieren */
	$script .= "$(document).ready(function() {
		$('.refresh_button').click(function(){return refresh_preview(3);});
		show_bzz();
		$('#bzz_use').change(show_bzz);
	});";
	
	/* Bei "Weiter" zur nächsten Seite weiterleiten */
	if (isset($_POST['do_next'])) {
		header("Location: ".createURL("designer4")); 
		exit;
	}
	
	/* Bei "Zurück" zur vorherigen Seite weiterleiten */
	if (isset($_POST['do_prev'])) {
		header("Location: ".createURL("designer2")); 
		exit;
	}
	
	
?>

<?php /* Schritt 3 im Brief erzeugen */ ?>

<h1>Brief erzeugen</h1>

<form class="designer_form" action="<?= createURL("designer3") ?>" method="post">

<div class="designer_left">
	<a href="letter.pdf" class="iframe" target="_blank"><img class="letter_preview_297" id="letter_preview" src="/letter.png" alt="Briefvorschau" /></a>
	<input type="submit" name="do_refresh" value="Vorschau aktualisieren" class="refresh_button icon_button icon_button_reload letter_preview_button" />	
</div>

<div class="designer_right">


	<?php /* Empfängerdaten können eingegeben werden */ ?>

	<h2><span class="gray">Schritt 3/5 : </span> Empfänger</h2>

		
		<a href="<?= $swap_link ?>" id="designer3_swap"><?= $swap_text ?></a>
		<input type="hidden" id="empfaenger_show_normal" name="empfaenger_show_normal" value="<?=$show_normal?'1':'0'?>" />
	
		<div id="designer3_normal" <?= $show_normal?'':'style="display:none"'?>>
			<div class="designer_form_row use_hover">
				<label for="empfaenger_firmenname">Firmenname</label>
				<input type="text" name="empfaenger_firmenname" id="empfaenger_firmenname" value="<?=$_SESSION['empfaenger_firmenname']?>" />
				<div class="designer_form_tooltip">
				Wenn Sie eine Firma anschreiben wollen, tragen Sie hier den Firmennamen ein.<br />
				<span class="gray">Dieses Feld ist optional.</span>
				</div>
			</div> 
	
			<div class="designer_form_row use_hover">
				<label for="empfaenger_anrede">Anrede</label>
				<input type="text" name="empfaenger_anrede" id="empfaenger_anrede" value="<?=$_SESSION['empfaenger_anrede']?>" />
				<div class="designer_form_tooltip">
				Falls erforderlich, tragen Sie hier die Anrede des Empfängers ein.<br />
					<span class="gray">Dieses Feld ist optional.</span>
				</div>
			</div> 
	
			<div class="designer_form_row use_hover">
				<label for="empfaenger_vorname">Vorname</label>
				<input type="text" name="empfaenger_vorname" id="empfaenger_vorname" value="<?=$_SESSION['empfaenger_vorname']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie hier den Vornamen des Empfängers ein.<br />
					<span class="gray">Dieses Feld ist optional.</span>
				</div>
			</div>
			 
			<div class="designer_form_row use_hover">
				<label for="empfaenger_nachname">Nachname</label>
				<input type="text" name="empfaenger_nachname" id="empfaenger_nachname" value="<?=$_SESSION['empfaenger_nachname']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie hier den Nachnamen des Empfängers ein.<br />
					<span class="gray">Dieses Feld ist optional.</span>
				</div>
			</div> 
			
			<div class="designer_form_row use_hover">
				<label for="empfaenger_strasse">Straße / Postfach (*)</label>
				<input type="text" name="empfaenger_strasse" id="empfaenger_strasse" value="<?=$_SESSION['empfaenger_strasse']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie in dieses Feld die Straße oder das Postfach des Empfängers ein. <br />
					<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
				</div>
			</div> 
			
			<div class="designer_form_row use_hover">
				<label for="empfaenger_hausnummer">Hausnummer</label>
				<input type="text" name="empfaenger_hausnummer" id="empfaenger_hausnummer" value="<?=$_SESSION['empfaenger_hausnummer']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie hier die Hausnummer des Empfängers ein. Bei Angabe eines Postfachs lassen Sie dieses Feld leer.<br /> 
					<span class="gray">Dieses Feld ist optional.</span>	
				</div>
			</div> 
	
			<div class="designer_form_row use_hover">
				<label for="empfaenger_plz">Postleitzahl (*)</label>
				<input type="text" name="empfaenger_plz" id="empfaenger_plz" value="<?=$_SESSION['empfaenger_plz']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie hier die Postleitzahl des Empfängers ein.<br />
					<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
				</div>
			</div> 
			
			<div class="designer_form_row use_hover">
				<label for="empfaenger_ort">Ort / Stadt (*)</label>
				<input type="text" name="empfaenger_ort" id="empfaenger_ort" value="<?=$_SESSION['empfaenger_ort']?>" />
				<div class="designer_form_tooltip">
				Tragen Sie hier den Ort des Empfängers ein.<br />
					<span class="gray">Dieses Feld sollte ausgefüllt werden.</span>
				</div>
			</div> 
		</div>
		
		
		<div <?= $show_normal?'style="display:none"':''?> id="designer3_full" class="designer_form_row use_hover designer_form_row_tall">
			<label for="empfaenger_full">Adressfeld</label><br />
			<textarea name="empfaenger_full" id="empfaenger_full" class="full_width"><?=$_SESSION['empfaenger_full']?></textarea>
			<div class="designer_form_tooltip">
				Adressen, die vom Standard abweichen, können hier direkt eingetragen werden.
			</div>
		</div>
		
		<div class="hspace20"></div>
		
		<div class="icon_with_text">
		<div class="icon icon_adress"></div>
		
		<?php /* Wahlweise kann auch bei registrierten Benutzern eine Adresse aus dem Adressbuch geladen werden */ ?>
		
		<?php 
		if (!$user_is_logged_in) {
			echo 'Sie wollen nicht jedes mal die komplette Empfänger-Adresse eingeben? Melden sie sich kostenlos an und verwalten sie ihr eigenes Adressbuch! 
			<a class="iframe orange_button" href="login" target="_blank">Registrieren oder Login</a>';
		}
		else
		{ 
			echo 'Fügen Sie eine Adresse aus Ihrem Adressbuch ein:<div style="height:10px;"></div><a class="iframe orange_button" target="_blank" href="designer3adressbuch">Adressbuch öffnen</a>';
		}
		?>
	</div>

		
		<input type="submit" class="button_prev orange_button" name="do_prev" value="&laquo; Zurück" />
		<input type="submit" class="button_next orange_button" name="do_next" value="Weiter &raquo;" />
		
</div>

</form>

<div class="designer_clear"></div>