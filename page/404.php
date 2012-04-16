<?php 
	/* Diese Seite zeigt dem Benutzer an, dass die gewünschte Seite nicht existiert. Das Umleiten übernimmt die .htaccess */
	$title = "Datei nicht gefunden";
	header("HTTP/1.0 404 Not Found"); 
?>
<h1>Datei nicht gefunden</h1>
<h2>Leider konnten wir die angegebene Datei nicht finden.</h2>
<p>Vielleicht hat sich ja ein Tippfehler eingeschlichen? Sollte dem nicht der Fall sein, 
würden wir uns über einen kurzen Fehlerbericht freuen.
Schicken Sie uns dazu einfach eine <a href="mailto:mail@rapidletter.de">E-Mail</a>.</p>
<p>Zurück zur <a href="<?php echo createURL(); ?>">Startseite</a>.</p>