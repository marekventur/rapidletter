<?php 
	/* Die "Sie sind nicht eingeloggt"-Seite */

	$title = "Fehler";
	
	/* Login-Dialog öffnen */
	$script = "
	$(document).ready(function() { 
		$.fn.colorbox({
			width: '800px',
			height: '600px',
			iframe: true,
			opacity:0.4,
			href:\"login\"
		});
	});"; 
?>
<h1>Fehler</h1>
<h2>Sie sind nicht eingeloggt.</h2>
Um diese Seite aufzurufen, müssen sie sich einloggen: <a href="login">Login</a>