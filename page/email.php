<?php 
	/* Brief per E-Mail versenden (Formular) */
	require_once("inc/const.php");
	require_once("inc/init.php");
	require_once("inc/functions.php");
	require_once("inc/session.php");
	

	$title = "EMail";
	$script = "";
	$template = "plain";
	
	
?>

<div id="header">
	<h1>Brief per E-Mail zusenden</h1>
</div>
 
<!-- Formulargerüst zum Eingeben der Email Daten -->
<form action="<?=createURL("sendmail")?>" method="post">

	<fieldset class="verschicken">
	
	
		<legend><b>Diesen Brief an eine E-Mail Adresse schicken</b></legend>
		<table style="width:400pt;" >
			<tr>
				<td>		<label for="verschickenan">E-Mail Adresse:*</label></td>
				<td>		<input class="verschicken_input" type="text" name="verschickenan" style="width:271pt;" id="verschickenan" value="" placeholder="name@domain.de" /></td>
			</tr>
			<tr>
				<td>		<label for="subject">Betreff: </label></td>
				<td>		<input class="verschicken_input" type="text" name="subject" style="width:271pt;" id="subject" value="Ihr persönlicher Brief, generiert mit Rapidletter.de" /></td>
			</tr>
			<tr>	
				<td>		Nachricht: </td>
				<td>		<textarea name="nachricht" rows="9" cols="60" />
Sehr geehrter Nutzer von Rapidletter.de,

Sie haben den Service von Rapidletter.de genutzt und einen Brief online generiert. Ihren Brief finden Sie im Anhang der E-Mail.

Viele Grüße,
Ihr Rapidletter-Team</textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Abschicken"></td>
				
			</tr>
		</table>
	
	</fieldset>	
</form>
