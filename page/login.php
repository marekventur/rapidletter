<?php 
	/* Die Login bzw. Registrierungsseite */
	$title = "Login und Registrieren";

	$template = "plain";
	
	if($user_is_logged_in) {
		echo '<h1>Sie sind bereits eingeloggt.</h1>';
	}
	else
	{
	
	if (isset($_POST['login_submit'])) {
		$sql = "SELECT id from benutzer where email='".mysql_real_escape_string($_POST['login_email'])."' AND (password = crypt('".mysql_real_escape_string($_POST['login_password'])."', password) OR md5('".mysql_real_escape_string($_POST['login_password'])."') = password) LIMIT 1;";
		$res = mysql_query($sql) or die(mysql_error());
		if($row = mysql_fetch_array($res)){
			$_SESSION['user'] = $row['id'];
		  	header("Location: ".$_POST['ref']); 
			exit;
		} 
		else
		{
			$login_error = true;
		}
	}	
	
	$valid = true;
	
	if (isset($_POST['register_submit'])) {
	
		/* E-Mail valide? */
		if ((!check_email_address($_POST['register_email'])) && $valid) {
			$register_email_error1 = true;
			$valid = false;
		}
		
		/* E-Mail schon vergeben? */
		if ($valid) {
			$sql = "SELECT email from benutzer where email='".mysql_real_escape_string($_POST['register_email'])."' LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			if($row = mysql_fetch_array($res)){
				$register_email_error2 = true;
				$valid = false;
			} 
		}
		
		/* E-Mail 2mal gleich? */
		if (($_POST['register_email'] != $_POST['register_email2']) && $valid) {
			$register_email2_error = true;
			$valid = false;
		}
		
		/* Passwort zu kurz? */
		if ((strlen($_POST['register_password']) < 7) && $valid) {
			$register_password_error = true;
			$valid = false;
		}
		
		/* Passwort 2mal gleich? */
		if (($_POST['register_password'] != $_POST['register_password2']) && $valid) {
			$register_password2_error = true;
			$valid = false;
		}
		
		/* Wenn alles ok: anlegen */
		if ($valid) {
			$sql = "INSERT INTO benutzer (password, email, ga1, ga2, ga3, isadmin) VALUES 
			(crypt('".mysql_real_escape_string($_POST['register_password'])."', gen_salt('bf')), 
				'".mysql_real_escape_string($_POST['register_email'])."',
'Firma Mustermann GmbH
Musterstraße 1
12345 Musterhausen
Deutschland',
'Telefon: 012/3456789
Fax: 012/3456789
Internet: www.musterfirma.de
E-Mail: info@musterfirma.de',
'Bank Musterhausen
BLZ 12345678
Konto 98765432
USt-IdNr.: DE123456789', 1) returning id;";
			
			$res = mysql_query($sql) or die(mysql_error());
			if($row = mysql_fetch_array($res)){
				$_SESSION['user'] = $row['id'];
		  		header("Location: ".$_POST['ref']); 
			}
		  	
			exit;
		}
	}
	
	/* Bei Register-Fehler das Fieldset nicht ausblenden */
	if ($valid) {
		$script = "$(document).ready(function() {
			$('#fieldset_create_account').hide();
			$('#button_create_account').show().click(function() {
				$('#button_create_account').hide(300, function() {
					$('#fieldset_create_account').show(300);
				});
			});
		});";
	}	
	
	
?>
<div id="header">
	<h1>Login oder Registrierung</h1>
</div>

<form action="<?php echo createURL("login"); ?>" method="post">
	<fieldset class="login_fieldset">
		<legend><strong>Login:</strong> Sie haben schon einen Account</legend>
		
		<label for="login_email">E-Mail: </label>
		<input class="login_input" type="text" name="login_email" id="login_email" value="" placeholder="name@domain.de" /><br />
		
		<label for="login_password">Passwort: </label>
		<input class="login_input" type="password" name="login_password" id="login_password" value=""  /><br />
		<?php if (isset($login_error)) echo '<div class="login_error">Der Benutzername oder das Passwort sind falsch</div>'; ?>
		
		<input type="hidden" name="ref" value="<?= $_SERVER['HTTP_REFERER'] ?>" />
		
		<input type="submit" name="login_submit" class="login_submit" value="Login &raquo;" />
		
	
	</fieldset>	
</form>
  
<span class="orange_button" id="button_create_account" style="display: none;">kostenlosen Account anlegen  &raquo;</span>

<form action="<?php echo createURL("login"); ?>" method="post">
	<fieldset class="register_fieldset" id="fieldset_create_account" >
		<legend><strong>Registrierung:</strong> Sie wollen sich einen Account anlegen</legend>
		
		<label for="register_email">E-Mail: </label>
		<input class="register_input" type="text" name="register_email" id="register_email" value="" placeholder="name@domain.de" />
		<?php if (isset($register_email_error1)) echo '<span class="register_error">E-Mail-Adresse ungültig</span>'; ?>
		<?php if (isset($register_email_error2)) echo '<span class="register_error">E-Mail-Adresse bereits vergeben</span>'; ?>
		<br />
		
		<label for="register_email2">E-Mail (wiederholen): </label>
		<input class="register_input" type="text" name="register_email2" id="register_email2" value="" placeholder="name@domain.de" />
		<?php if (isset($register_email2_error)) echo '<span class="register_error">E-Mail-Adresse stimmt nicht überein</span>'; ?>
		<br />
		
		<label for="register_password">Passwort: </label>
		<input class="register_input" type="password" name="register_password" id="register_password" value=""  />
		<?php if (isset($register_password_error)) echo '<span class="register_error">Passwort ist zu kurz</span>'; ?>
		<br />
		
		<label for="register_password2">Passwort (wiederholen): </label>
		<input class="register_input" type="password" name="register_password2" id="register_password2" value=""  />
		<?php if (isset($register_password2_error)) echo '<span class="register_error">Passwörter stimmen nicht überein</span>'; ?>
		<br />
		
		<input type="hidden" name="ref" value="<?= $_SERVER['HTTP_REFERER'] ?>" />
		
		<input type="submit" name="register_submit" class="register_submit" value="Registrieren &raquo;" /> 
	</fieldset>	
</form>
<br />
<a class="orange_button" id="button_lost_password" href="<?= createURL("lostpassword"); ?>">Ich habe mein Passwort vergessen</a>
		

<?php } ?>