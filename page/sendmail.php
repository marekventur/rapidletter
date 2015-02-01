<?php 
	/* Dieses Script sendet den Brief per E-Mail ab */
	require_once("inc/mail/class.phpmailer.php");
	require_once("inc/mail/class.smtp.php");
	require_once("email_conf.php");
	
	$template = "plain";
	
	// Pfad beziehen
	require_once(PATH."letter/letter_".getSessionVarEmpty('design').".php");
		
	if (isset($_POST['verschickenan']) && check_email_address($_POST['verschickenan'])) {
		// Brief generieren
		$letter = new Letter();
		initLetterFromSession($letter);
		$file = $letter->SaveLocal();
			
		
		$mail = new PHPMailer();
		load_credentials($mail);  // Funktion aus der google_credentials.php
		$mail->CharSet = 'UTF-8';
		$mail->SetFrom('mail@rapidletter.de', 'Rapidletter');
		//$mail->AddReplyTo($_POST['replyto']);
		$mail->Subject = ($_POST['subject']);
		
		$mail->Body = ($_POST['nachricht']);		
		
		$mail->AddAttachment($file, "Brief.pdf");
		
		$mail->AddAddress($_POST['verschickenan']);
		if(!$mail->Send()) { 
			$msg = 'Mailer Error: ' . $mail->ErrorInfo; 
		}
			
		unlink($file);
		$msg = "Ihr Brief wurde verschickt!";
	}
	else
	{
		$msg = "Keine gültige E-Mail-Adresse angegeben.";
	}	
	
	
	$script = "$(document).ready(function() {
		$('#click_button').click(function() {parent.close_colorbox();});
	});";
	
?>

<div id="header">
	<h1>Brief per E-Mail zusenden</h1>
</div>

<p><?=$msg?></p>
<div class="hspace20"></div>
<span class="orange_button" id="click_button">Fenster schließen</span>