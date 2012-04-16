<?php 
	$title = "Schritt 5 von 5";
	
	$_SESSION['designer_nr'] = max(5, $_SESSION['designer_nr']);
	
	$script = "";
?>
<h1>Brief erzeugen</h1>

<div class="designer_left">
	<a href="letter.pdf" class="iframe" target="_blank"><img class="letter_preview_297" id="letter_preview" src="letter.png" alt="Briefvorschau" /></a>
		
</div>

<div class="designer_right">
	<h2><span class="gray">Schritt 5/5 : </span> Download & Speichern</h2>
	
	<div class="icon_with_text icon_with_text_2_lines">
		<div class="icon icon_pdf"></div>
		<div class="spacer_line"></div>
		Als PDF speichern oder ausdrucken:<br /> 
		<a href="letter_save.pdf">PDF-Datei speichern</a> |
		<a class="iframe" href="letter.pdf">PDF-Datei öffnen</a>
	</div>
	
	<div class="icon_with_text icon_with_text_2_lines">
		<div class="icon icon_letter"></div>
		<div class="spacer_line"></div>
		Via E-Mail verschicken:<br /> 
		<a class="iframe" href="email">PDF-Datei verschicken</a>
	</div>

	<?php 
		if (!$user_is_logged_in) {
	?>
	<div class="icon_with_text">
		<div class="icon icon_save"></div>
		Brief und Adressdaten abspeichern:<br />
		<span class="gray">Sparen Sie sich den Aufwand, jedes mal alle Daten einzugeben.</span><br /> 
		<a class="iframe" href="login">Account anlegen</a>
	</div>	
	<?php 
		} else {
	?>
	<div class="icon_with_text icon_with_text_2_lines">
		<div class="icon icon_save"></div>
		<div class="spacer_line"></div>
		Brief abspeichern:<br />
		<a class="iframe" href="saveletter">Brief speichern</a>
	</div>	
	<?php } ?>
	 
	<div class="icon_with_text">
		<div class="icon icon_social"></div>
		<div class="spacer_line"></div>
		Brief als Vorlage veröffentlichen<br /> 
		<span class="gray">Ihr Brief könnte anderen helfen, die eine Vorlage suchen.</span><br />
		<a href="createpubliclink">Erzeugen Sie einen öffentlichen Link und schicken Sie ihn weiter</a>
	</div>
	
	<?php if ((isset($user)) && ($user['isadmin']==1)) { ?>
	<div class="icon_with_text">
		<div class="icon icon_wallet"></div>
		<div class="spacer_line"></div>
		Brief via Deutsche Post verschicken<br /> 
		<span class="gray">Lassen sie diesen Brief audrucken, kuvertieren und verschicken.</span><br />
		<a class="iframe" href="<?php echo createURL("sendpost"); ?>">Verschicken sie diesen Brief per Post</a>
	</div>
	<?php } ?>
	
	<a href="<?= createURL("designer4"); ?>" class="button_prev orange_button">&laquo; Zurück</a>
	<a href="<?= createURL(); ?>" class="button_next orange_button">&laquo; Zur Startseite</a>
	
</div>

<div class="designer_clear"></div>