<?php 
	$title = "Schritt 4 von 5";
	
	/* Brief ggf. in der Session erzeugen */
	initLetter();
	
	/* Aktuellen Schritt in der Session festhalten */
	$_SESSION['designer_nr'] = max(4, $_SESSION['designer_nr']);
	
	/* POST-Daten verarbeiten */
	designer_handle_post(4);
	
	/* Javascript initialisieren */
	$script = "$(document).ready(function() {
		$('.refresh_button').click(function(){return refresh_preview(4);});
	});";
	
	/* Bei "Weiter" zur nächsten Seite weiterleiten */
	if (isset($_POST['do_next'])) {
		header("Location: ".createURL("designer5")); 
		exit;
	}
	
	/* Bei "Zurück" zur vorherigen Seite weiterleiten */
	if (isset($_POST['do_prev'])) {
		header("Location: ".createURL("designer3")); 
		exit;
	}
?>
<h1>Brief erzeugen</h1>

<form class="designer_form" action="<?php echo createURL("designer4"); ?>" method="post">

<div class="designer_left">
	<a href="letter.pdf" class="iframe" target="_blank"><img class="letter_preview_297" id="letter_preview" src="/letter.png" alt="Briefvorschau" /></a>
	<input type="submit" name="do_refresh" value="Vorschau aktualisieren" class="refresh_button icon_button icon_button_reload letter_preview_button" />	
</div>

<div class="designer_right">
	<h2><span class="gray">Schritt 4/5 : </span> Betreff & Text</h2>	
		
	<?php /* Wenn keine BZZ vorhanden, dann muss das Datum und der Ort hier abgefragt werden */?>
	<?php if (getSessionVarEmpty('bzz_use') != 'bzz') {  ?>
	<label id="ortdatum_label" for="betreff">Ort und Datum:</label>
	<input type="text" name="ortdatum" id="ortdatum" value="<?=html_entities($_SESSION['ortdatum'])?>" />
	<?php } ?>
	
	<label id="betreff_label" for="betreff">Betreff:</label>
	<input type="text" name="betreff" id="betreff" value="<?=html_entities($_SESSION['betreff'])?>" />
	
	<a class="iframe icon_button icon_button_template" href="vorlagen" target="_blank"><div class="icon_button_spacer"></div>Brieftext-Vorlage laden</a>
	<a class="iframe icon_button icon_button_textblock" href="textbausteine" target="_blank"><div class="icon_button_spacer"></div>Textblock einfügen</a>
	<textarea name="text" id="text"><?=html_entities($_SESSION['text'])?></textarea>

	<input type="submit" class="button_prev orange_button" name="do_prev" value="&laquo; Zurück" />
	<input type="submit" class="button_next orange_button" name="do_next" value="Weiter &raquo;" />
	
</div>

</form>

<div class="designer_clear"></div>