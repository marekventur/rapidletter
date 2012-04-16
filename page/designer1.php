<?php 
	$title = "Schritt 1 von 5";
	
	/* Brief ggf. in der Session erzeugen */
	initLetter();

	/* Aktuellen Schritt in der Session festhalten */	
	$_SESSION['designer_nr'] = max(1, $_SESSION['designer_nr']);
	 
	/* Per GET übergebene Design-Variable speichern */
	if (isset($_GET['design'])) {
		$_SESSION['design'] = $_GET['design'];
		letter_has_changed();
	}
	
	/* Logo löschen */
	if (isset($_GET['logo']) && ($_GET['logo'] == "delete")) {
		$_SESSION['header'] = "";
		@unlink(PATH."uploads/logo/big_" . $_SESSION['uid'].".png");
		@unlink(PATH."uploads/logo/small_" . $_SESSION['uid'].".png");
		letter_has_changed();
	}
	
	/* POST-Daten verarbeiten */
	designer_handle_post(1);
	
	/* Evtl. Logo-Upload bearbeiten */
	handleUploadLogo();
	
	/* Effekte etc. für Designer 1 laden */
	$script = "init_designer1();";
	
	/* Bei "Weiter" zur nächsten Seite weiterleiten */
	if (isset($_POST['do_next'])) {
		header("Location: ".createURL("designer2")); 
		exit;
	}
	
	/* Logo vorhanden? */
	static_exists('uploads/logo/small_'.$_SESSION['header'].'.png');
	
	
?>

<?php /* Erster Schritt bei Erzeugung des Briefes */?>
<h1>Brief erzeugen</h1>
<form enctype="multipart/form-data" class="designer_form" action="<?php echo createURL("designer1"); ?>" method="post">
	
<?php /* Vorschaubild */ ?>
	
	<div class="designer_left">
		<a href="letter.pdf" class="iframe" target="_blank"><img class=" letter_preview_297" id="letter_preview" src="/letter.png" alt="Briefvorschau" /></a>
		<input type="submit" name="do_refresh" value="Vorschau aktualisieren" class="refresh_button icon_button icon_button_reload letter_preview_button" />
		
	</div>
		
<?php /* Auswahl ob klassisches oder modernen Design, Geschäfts- oder Privatbrief */?>	
	
	<div class="designer_right">
		<h2><span class="gray">Schritt 1/5 : </span> Design wählen</h2>

		<div class="design_choose"><div class="design_choose_inner" >
			<a id="design_classic" class="use_hover letter_preview_150 <?=(($_SESSION['design']=="classic")?"letter_preview_150_active":"letter_preview_150_noactive")?>" href="<?=createURL("designer1", "design=classic")?>">
				<img src="img/styles/classic_150.png" alt="Design Classic" />
				<div class="letter_preview_hover"><div class="inner">
					<strong>Classic</strong><br />
					klassischer Brief
				</div></div>
			</a>
			
			<a id="design_modern" class="use_hover letter_preview_150 <?=(($_SESSION['design']=="modern")?"letter_preview_150_active":"letter_preview_150_noactive")?>" href="<?=createURL("designer1", "design=modern")?>">
				<img src="img/styles/modern_150.png" alt="Design Modern" />
				<div class="letter_preview_hover"><div class="inner">
					<strong>Modern</strong><br />
					moderne Schrift
				</div></div>
			</a>
			
			<a id="design_blau" class="use_hover letter_preview_150 <?=(($_SESSION['design']=="blau")?"letter_preview_150_active":"letter_preview_150_noactive")?>" href="<?=createURL("designer1", "design=blau")?>">
				<img src="img/styles/blau_150.png" alt="Design Blau" />
				<div class="letter_preview_hover"><div class="inner">
					<strong>Blau</strong><br />
					mit blauem Rand
				</div></div>
			</a>
			
			
			<a id="design_formatb" class="use_hover letter_preview_150 <?=(($_SESSION['design']=="formatb")?"letter_preview_150_active":"letter_preview_150_noactive")?>" href="<?=createURL("designer1", "design=formatb")?>">
				<img src="img/styles/formatb_150.png" alt="Design Format B" />
				<div class="letter_preview_hover"><div class="inner">
					<strong>Format B</strong><br />
					nach DIN 5008
				</div></div>
			</a>
			
		</div></div>

		
		<input type="hidden" name="design" id="design" value="<?=$_SESSION['design']?>" />
		
		<div class="letter_preview_clear"></div>
	

		<div class="designer_form_row use_hover">
			<label for="letter_type">Briefart</label>
			<select name="letter_type" id="letter_type">
				<option value="business" <?=(($_SESSION['letter_type']=="business")?"selected=\"selected\"":"")?>>Geschäftsbrief</option>
				<option value="private" <?=(($_SESSION['letter_type']=="private" )?"selected=\"selected\"":"")?>>Privatbrief</option>
			</select>
			<div class="designer_form_tooltip">
				Wählen Sie hier, ob Sie einen Geschäftsbrief oder einen privaten Brief schreiben wollen. Geschäftsbriefe müssen die 
				gesetzlich geforderten Pflichtangaben entsprechend der jeweiligen Gesellschaftsform führen.<br />
			</div>
		</div> 
	
		<?php /* zusätzliche Auswahl zu Sichtfensterrahmen und Lochfalzmarkierung */ ?>
			
		<div class="designer_form_row use_hover">
			<label for="showFensterLine">Sichtfensterrahmen</label>
			<input type="checkbox" name="showFensterLine" id="showFensterLine" <?=(($_SESSION['showFensterLine']=="1")?"checked=\"checked\"":"")?> />
			<div class="designer_form_tooltip">
				Wenn diese Option gewählt ist, werden die Ecken des Sichtfensters im Brief markiert. <br />
				<span class="gray">Dies kann hilfreich sein, um zu kontrollieren, ob der Brief richtig gefaltet wurde.</span>
			</div>
		</div> 	
		
		<div class="designer_form_row use_hover">
			<label for="showFalzLine">Falz- und Lochmakierungen</label>
			<input type="checkbox" name="showFalzLine" id="showFalzLine" <?=(($_SESSION['showFalzLine']=="1")?"checked=\"checked\"":"")?> />
			<div class="designer_form_tooltip">
				Diese Markierungen dienen zur Orientierung beim Falten oder Lochen des Briefes.
			</div>
		</div> 	

		<div class="clear_left"></div>

		<?php /* Logoauswahl */  ?>

		<div class="designer_form_row use_hover">
			<span class="label">Logo</span>
			<input type="hidden" name="letter_logo" id="letter_logo" value="no" />
			<div class="designer_like_input">
				<?php if ($_SESSION['header'] == "") {?>  
				Kein Logo gewählt.<br />diese
				<?php } else { ?>
				<img id="logo_preview" src="/uploads/logo/small_<?=$_SESSION['header']?>.png" alt="Logo" /><br />
				<a href="<?=createURL("designer1", "logo=delete")?>">Logo löschen</a>
				<?php } ?>
			</div>
			<div class="designer_form_tooltip">
				Falls Sie über ein persönliches Logo verfügen, können Sie dieses hier einfügen. Es werden Bilder im *.jpg 
				und *.png Format mit einer maximalen Dateigröße von 2 Mb unterstützt.
			</div>
		</div> 	
		
		<div class="clear_left"></div>
		<?php if ($_SESSION['header'] == "") {?>  
		<input type="file" name="letter_logo_upload" id="letter_logo_upload" />
		<?php } ?>
		
		<input type="submit" class="button_next orange_button" name="do_next" value="Weiter &raquo;" />

	
	</div>
	
</form>

<div class="designer_clear"></div>