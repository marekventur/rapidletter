<?php 
	$title = "Startseite";
?>

<?php if ($user_is_logged_in) { ?>
<h1>Willkommen <?=$user['email']?>!</h1>
<?php } else { ?>
<h1>Willkommen Gast!</h1>
<?php } ?>
<div class="half_left">
	<h2>Erstellen Sie Ihren Brief ganz einfach online.</h2>
	<div class="icon_with_text">
		<div class="icon icon_coffee"></div>
		Sparen Sie sich Zeit und Nerven.
		<div class="gray">
			Anstatt eine eigene Vorlage zu basteln, 
			können Sie unsere professionellen Vorlagen verwenden
		</div>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_clipboard"></div>
		Mit fertigen Textbausteinen. 
		<div class="gray">
			Für viele Formulierungen bieten wir vorgefertigte 
			Textbausteine, die Sie einfach nur einfügen müssen
		</div>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_pdf"></div>
		Als PDF speichern oder ausdrucken. 
		<div class="gray">
			Der fertige Brief wird direkt als PDF exportiert, sodass
			die Datei auf jedem Rechner geöffnet werden kann
		</div>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_wallet"></div>
		Absolut kostenlos. 
		<div class="gray">
			RapidLetter ist sowohl für Privatpersonen als auch für 
			Firmen absolut kostenlos
		</div>
	</div>
	
</div>
<div class="half_right">

	
	<h2>In 5 Schritten zum fertigen Brief:</h2>
	<ul class="numbered_list">
		<li>Vorlage und Design auswählen</li>
		<li>Absender eintragen</li>
		<li>Empfänger eintragen</li>
		<li>Brief schreiben oder aus Textbausteinen zusammenklicken</li>
		<li>Ergebnis ansehen, speichern oder per E-Mail verschicken</li>
	</ul>
	<a href="<?= createURL("newletter"); ?>" class="orange_button" id="button_start">Brief-Generator&nbsp;starten&nbsp;&raquo;</a>
	<!--  
	<div id="index_info_box">
		<img id="letter_small" src="img/letter_small.png" alt="Brief" />
			
		<p id="index_info_box_first">
			Versenden sie ihren  Brief 
			direkt Brief direkt online 
			mit der deutschen Post.	
		</p>
		<p>
			Ihr Brief wird gedruckt, 
			kuvertiert und frankiert.
		</p>	
		<p>
			Ohne Anmeldung,<br />
			direkt online
		</p>
		<p>	
			<a href="<?= createURL("postbrief"); ?>">Mehr Infos &raquo;</a>
		</p>
		<div class="price_tag">
			<div class="price">
				1,42 €
			</div>
			<div class="info">
				2-seitig<br />
				schwarz-weiß
			</div>
		</div>
		
		<div class="half_clear"></div> 
	</div>
	-->
</div>
	
<div class="half_clear"></div> 
