<?php 
	$title = "Öffentlichen Link erstellen";
	
	if (isset($_POST['submit'])) {
		if (isset($user['id']))
			$user_id = $user['id'];
		else
			$user_id = 0;
		
		$uid = saveLetter($user_id, true, $_POST['empfaenger']=='yes', false, $_POST['title'], $_POST['desc'], $_POST['use']=='yes');
		saveLetterPNG($uid, false, $_POST['empfaenger']=='yes');
		header("Location: ".createURL("brief", "id=".$uid)); 
		exit;
		
	}
?>
<h1>Brief erzeugen</h1>

<div class="designer_left">
	<a href="letter.pdf" class="iframe" target="_blank"><img class="letter_preview_297" id="letter_preview" src="letter.png" alt="Briefvorschau" /></a>
		
</div>

<div class="designer_right">
	<h2>Öffentlichen Link erstellen</h2>
	
	<form class="designer_form" action="<?php echo createURL("createpubliclink"); ?>" method="post">
		<p>
			Bevor Ihr Brief öffentlich zugänglich gemacht wird, sollten Sie prüfen, dass der Betreff und der 
			Text Ihres Briefes <strong>keine privaten oder vertraulichen Informationen</strong> enthält. Sollten Sie sich nicht 
			mehr sicher sein, können Sie dies noch einmal in <a href="designer4">Schritt 4</a> überprüfen und gegebenenfalls ändern.
		</p>
		
		<p>
			Der <strong>Absender</strong> des Briefes wird in jedem Fall <strong>nicht mit in den öffentlichen Brief übernommen</strong>. 			
		</p>
		
		<p>
			Sie können den Brief zu jedem Zeitpunkt über Ihr Profil wieder löschen. 
			Er ist dann auch für andere, die dem Link folgen, nicht mehr einsehbar. 
		</p>
		
		<div class="hspace20"></div>
		
		<p>
			<label for="empfaenger">Soll der Empfänger übernommen werden?</label>
			<select name="empfaenger" id="empfaenger">
				<option value="yes">Ja, Empfänger aus Brief übernehmen</option>
				<option value="no" selected="selected">Nein, Empfängerfelder leer lassen</option>
			</select>
		</p>
		
		<p>
			<label for="title">Welchen Titel soll Ihr Link haben?</label><br />
			<input class="publiclink_title" type="text" name="title" value="<?=$_SESSION['betreff']?>" id="title" />
		</p>
		
		<p>
			<label for="desc">Möchten Sie noch eine Beschreibung hinzufügen?</label><br />
			<textarea class="publiclink_desc" name="desc" id="desc" ></textarea>
		</p>
		
		
		<p>
			<label for="use">Dürfen wir Ihren Link öffentlich, z.B. ihn auf der Startseite oder in sozialen Netzen anzeigen 
			und so auf ihn aufmerksam machen?</label>
			<select name="use" id="use">
				<option value="yes" selected="selected">Ja</option>
				<option value="no">Nein</option>
			</select>
		</p>
		
		<p>
			<input type="submit" name="submit" class="orange_button" value="Link generieren &raquo;" />
		</p>
		<a href="/designer5" class="button_prev"></a>
	
	</form>
</div>

<div class="designer_clear"></div>