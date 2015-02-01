<?php 
	/* Diese Seite hilft Benutzers, die ihr Passwort vergessen haben und schickt ihnen ein neues zu */
	$title = "Passwort vergessen";

	$template = "plain";
	
	if (isset($_POST['password_email'])) {
		$sql = "SELECT id, email FROM benutzer WHERE email = '".mysql_real_escape_string($_POST['password_email'])."' LIMIT 1;";	
		$res = mysql_query($sql) or die(mysql_error());	
		if($row = mysql_fetch_array($res)){
			$pool = "qwertzupasdfghkyxcvbnm23456789WERTZUPLKJHGFDSAYXCVBNM";
			$password = "";
			srand ((double)microtime()*1000000);
			for($index = 0; $index < 5; $index++)
				$password .= substr($pool,(rand()%(strlen ($pool))), 1);
			$sql = "UPDATE benutzer SET password = crypt('".$password."', gen_salt('bf')) WHERE id=".$row['id'].";";
			$res = mysql_query($sql) or die(mysql_error());	
				
			require_once("inc/mail/class.phpmailer.php");
			require_once("inc/mail/class.smtp.php");
			require_once("email_conf.php");
			
			
			$mail = new PHPMailer();
			load_credentials($mail);  // Funktion aus der google_credentials.php
			$mail->CharSet = 'UTF-8';
			$mail->SetFrom('mail@rapidletter.de', 'Rapidletter');
			$mail->Subject = 'Ihr neues Passwort bei Rapidletter.de';
			$mail->Body = ("Sehr geehrter Rapidletter-Benutzer,
	
Ihr Passwort wurde über unseren 'Passwort vergessen'-Dialog zurückgesetzt. 

Ihr neues Passwort lautet: ".$password."

Sie können sich ab sofort damit wieder einloggen und ihr Passwort ändern.

Mit freundlichen Grüßen,
Ihr Rapidlette-Team");		
			
			
			$mail->AddAddress($row['email']);
			if(!$mail->Send()) { 
				$msg = 'Mailer Error: ' . $mail->ErrorInfo; 
			}
			else
			{
				?>
<div id="header">
	<h1>Passwort zurücksetzen</h1>
</div>
<p>Ihr Passwort wurde zurückgesetzt.</p>
<p>Bitte kontrollieren sie nun ihren E-Mail-Account und evtl. ihren Spamordner.</p>	
				<?php 
			}
		} 
		else
		{
?>
<div id="header">
	<h1>Passwort zurücksetzen</h1>
</div>



<form action="<?php echo createURL("lostpassword"); ?>" method="post">
	<fieldset class="login_fieldset">
		<legend><strong>Passwort vergessen</strong></legend>
		
		<p style="color:red; ">Diese E-Mail-Adresse ist uns leider nicht bekannt.</p>
		
		<label for="password_email">E-Mail: </label>
		<input class="password_input" type="text" name="password_email" id="password_email" value="" placeholder="name@domain.de" /><br />
		
		<input type="submit" name="password_submit" class="orange_button" value="Passwort zurücksetzen &raquo;" />
	</fieldset>	
</form>



<?php
			
		}
	
	}
	else
	{	
	
?>
<div id="header">
	<h1>Passwort zurücksetzen</h1>
</div>

<form action="<?php echo createURL("lostpassword"); ?>" method="post">
	<fieldset class="login_fieldset">
		<legend><strong>Passwort vergessen</strong></legend>
		
		<label for="password_email">E-Mail: </label>
		<input class="password_input" type="text" name="password_email" id="password_email" value="" placeholder="name@domain.de" /><br />
		
		<input type="submit" name="password_submit" class="orange_button" value="Passwort zurücksetzen &raquo;" />
	</fieldset>	
</form>



<?php } ?>