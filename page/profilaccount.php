<?php
	/* Hier kann der Benutzer seine Accountdaten verwalten oder seinen Account löschen */
	
	$title = "Ihr Profil";
		
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		include ('components/profil_left.php');
		$script = "$(document).ready(function() { 
			init_delete_confirm_button('Ich möchte diesen Account löschen');		
		});";
		
		if (isset($_GET['delete']) && ($_GET['delete'] == 'account') && isset($_POST['submit'])) {
			echo "DELETE";
			$sql = "DELETE FROM benutzer WHERE id = ".$user['id']. " LIMIT 1;";
			mysql_query($sql) or die(mysql_error());
			unset($_SESSION['user']);
			header("Location: http://www.rapidletter.de"); 
			exit;
		}
		
		$email = $user['email'];
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
			$valid = true;
		
			if ((!check_email_address($_POST['email'])) && $valid) {
				$email_error1 = true;
				$valid = false;
			}
			if ($valid) {
				$sql = "SELECT email from benutzer where email='".mysql_real_escape_string($_POST['email'])."' LIMIT 1;";
				$res = mysql_query($sql) or die(mysql_error());
				if($row = mysql_fetch_array($res)){
					$email_error2 = true;
					$valid = false;
				} 
			}
			if (($_POST['email'] != $_POST['email2']) && $valid) {
				$email2_error = true;
				$valid = false;
			}
			
			if ($valid) {
			
				$sql = "UPDATE  
							benutzer 
						SET  
							email = '".mysql_real_escape_string($_POST['email'])."'
						WHERE  
							id = ".$user['id']."
						LIMIT 1;";
				mysql_query($sql) or die(mysql_error());
				
				$sql = "SELECT * from benutzer where id='".mysql_real_escape_string($_SESSION['user'])."' LIMIT 1;";
				$res = mysql_query($sql) or die(mysql_error());
				$user = mysql_fetch_array($res);	

				$email_success = true;
			}	
				
		}
		
		if (isset($_POST['password'])) {
			$valid = true;
		
			if (strlen($_POST['password']) < 7) {
				$password_error = true;
				$valid = false;
			}
			if (($_POST['password'] != $_POST['password2']) && $valid) {
				$password2_error = true;
				$valid = false;
			}
			
			if ($valid) {
			
				$sql = "UPDATE  
							benutzer 
						SET  
							password = crypt('".mysql_real_escape_string($_POST['password'])."', gen_salt('bf'))
						WHERE  
							id = ".$user['id'].";";
				mysql_query($sql) or die(mysql_error());
				$password_success = true;			
			}	
			
			
		}
		
?>

<div class="half_right">
	<h2>Ihre Accountdaten</h2>
	
	<form class="adressbuch_eintrag_form" action="<?=createURL("profilaccount")?>" method="post">
		<fieldset class="profil_fieldset">
		<legend>E-Mail-Adresse ändern</legend>
			<?php if (isset($email_error1)) echo '<div class="account_error">E-Mail-Adresse ungültig</div>'; ?>
			<?php if (isset($email_error2)) echo '<div class="account_error">E-Mail-Adresse bereits vergeben</div>'; ?>
			<?php if (isset($email_success)) echo '<div class="account_success">E-Mail-Adresse erfolgreich geändert</div>'; ?>
		
			<div class="designer_form_row ">
				<label for="email">E-Mail</label>
				<input type="text" name="email" id="email" value="<?=$email?>" />
			</div> 
			
			<?php if (isset($email2_error)) echo '<div class="account_error">Die E-Mail-Adressen sind nicht gleich</div>'; ?>
			
			<div class="designer_form_row ">
				<label for="email2">E-Mail (Wiederholen)</label>
				<input type="text" name="email2" id="email2" value="" />
			</div> 
			
			
			<input type="submit" name="submit" class="register_submit" value="Adresse ändern &raquo;" /> 
		</fieldset>
	</form>

	<form class="adressbuch_eintrag_form" action="<?=createURL("profilaccount")?>" method="post">
		<fieldset class="profil_fieldset">
		<legend>Passwort ändern</legend>
			<?php if (isset($password_error)) echo '<div class="account_error">Das Passwort ist zu kurz (mind. 7 Zeichen)</div>'; ?>
			<?php if (isset($password_success)) echo '<div class="account_success">Das Passwort wurde erfolgreich geändert</div>'; ?>
			
			<div class="designer_form_row ">
				<label for="password">Passwort</label>
				<input type="password" name="password" id="password" value="" />
			</div> 
			<?php if (isset($password2_error)) echo '<div class="account_error">Die Passwörter stimmen nicht überein</div>'; ?>
			
			<div class="designer_form_row ">
				<label for="password2">Passwort (Wiederholen)</label>
				<input type="password" name="password2" id="password2" value="" />
			</div> 
			
			<input type="submit" name="submit" class="register_submit" value="Passwort ändern &raquo;" /> 
		</fieldset>
	</form>
	<br /><br />
	
	<form class="" action="<?=createURL("profilaccount", "delete=account")?>" method="post">
	<input type="submit" name="submit" class="orange_button delete_confirm_button" value="Diesen Account löschen" />
	</form>
</div>
<div class="half_clear"></div> 
<?php } ?>