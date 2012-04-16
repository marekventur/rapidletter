<h1>Ihr Profil</h1>
<div class="half_left">
	<h2>Hier können Sie Ihre Daten verwalten</h2>
	
	<div class="icon_with_text">
		<div class="icon icon_save"></div>
		Verwalten Sie Ihre gespeicherten Briefe
		<div class="gray">zum Abrufen und Weiterverwenden</div>
		<a href="profil">Briefe verwalten</a>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_design"></div>
		Verwalten Sie Ihr Design
		<div class="gray">Logo & Standartdesign</div>
		<a href="profildesign">Design verwalten</a>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_card"></div>
		Verwalten Sie Ihre Absenderdaten
		<div class="gray">Adresse, Bezugszeichenzeile & Geschäftsdaten</div>
		<a href="profilabsender">Absenderdaten verwalten</a>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_adress"></div>
		Verwalten Sie Ihr Adressbuch
		<div class="gray">Ihre wichtigsten Kontakte auf einen Blick</div>
		<a href="profiladressbuch">Adressbuch verwalten</a>
	</div>
	
	<div class="icon_with_text">
		<div class="icon icon_account"></div>
		Verwalten Sie Ihre Accountdaten
		<div class="gray">Ihre E-Mail-Adresse, Ihr Passwort, Account löschen</div>
		<a href="profilaccount">Account verwalten</a>
	</div>
	
	<?php if ($user['isadmin']) { ?>
	<div class="icon_with_text">
		<div class="icon icon_clipboard"></div>
		Adminbereich
		<div class="gray">Datenbank zurücksetzen, Musterbriefe verwalten</div>
		<a href="admin">Adminbereich</a>
	</div>
	<?php } ?>
	
</div>