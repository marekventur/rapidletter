<?php 
	/* Dieses Script speichert einen Brief in die Datenbank ab */
	$title = "Brief speichern";
	$script = "";
	$template = "plain";
	
	if(!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		saveLetter($user['id'], false);
	
	
?>
<div id="header">
	<h1>Brief wurde gespeichert</h1>
</div>
<div class="hspace20"></div>
<p>
	Ihr Brief wurde gespeichert. Sie können ihn in ihrem Profil verwalten und bei Bedarf löschen. 
</p>
<div class="hspace20"></div>
<a href="profil" class="orange_button">Zu ihrem Profil &raquo;</a> 



<?php } ?>