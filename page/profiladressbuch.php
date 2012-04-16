<?php
	/* Auf dieser Seite kann der Benutzer sein Adressbuch verwalten */
	$title = "Ihr Profil";
	
	
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		include ('components/profil_left.php');
		$this_page = "profiladressbuch";
		
?>

<div class="half_right">
	<h2>Ihr Adressbuch</h2>
	
	<?php include "components/adressbuch.php"; ?>

</div>
<div class="half_clear"></div> 
<?php } ?>