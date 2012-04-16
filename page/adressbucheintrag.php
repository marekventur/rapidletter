<?php 
	$title = "Login und Registrieren";
	$script = "";
	$template = "plain";
	
	
	
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{	
		if (!isset($_GET['id'])) die('Keine ID angegeben');
		
		
		if ($_GET['id'] == 'new') {
			$eintrag = array(
				"firmenname" => "",
				"anrede" => "",
				"vorname" => "",
				"nachname" => "",
				"strasse" => "",
				"hausnummer" => "",
				"plz" => "",
				"ort" => "",
				"ort" => "",
				"id" => "",
				"show_normal" => "1",
				"full" => ""
			);
			$name = "Neuer Eintrag";
			$id = "new";
			
			if (isset($_POST['submit'])) {
				$sql = "INSERT INTO  
							empfaenger 
							(firmenname, anrede, vorname, nachname, strasse, hausnummer, plz, ort, show_normal, full, benutzer)
						VALUES  
							('".mysql_real_escape_string($_POST['firmenname'])."',
							'".mysql_real_escape_string($_POST['anrede'])."',
							'".mysql_real_escape_string($_POST['vorname'])."',
							'".mysql_real_escape_string($_POST['nachname'])."',
							'".mysql_real_escape_string($_POST['strasse'])."',
							'".mysql_real_escape_string($_POST['hausnummer'])."',
							'".mysql_real_escape_string($_POST['plz'])."',
							'".mysql_real_escape_string($_POST['ort'])."',
							'".mysql_real_escape_string($_POST['show_normal'])."',
							'".mysql_real_escape_string($_POST['full'])."',
							".$user['id'].");";
				mysql_query($sql) or die(mysql_error());
				
				$id = mysql_insert_id();
				
				$sql = "SELECT * FROM empfaenger WHERE id = ".$id." AND benutzer=".$user['id']." LIMIT 1;";
				$res = mysql_query($sql) or die(mysql_error());
				$eintrag = mysql_fetch_array($res);
				
				$script .= "top.location = top.location; ";
			}
		}
		else
		{
	
			
			
			$id= ($_GET['id']) * 1;
			
			$sql = "SELECT * FROM empfaenger WHERE id = ".$id." AND benutzer=".$user['id']." LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			if(!$eintrag = mysql_fetch_array($res)) {
				die('Eintrag nicht gefunden');
			}
			
			if (isset($_POST['submit'])) {
				$sql = "UPDATE  
							empfaenger 
						SET  
							firmenname =  	'".mysql_real_escape_string($_POST['firmenname'])."',
							anrede =  		'".mysql_real_escape_string($_POST['anrede'])."',
							vorname =  		'".mysql_real_escape_string($_POST['vorname'])."',
							nachname =  	'".mysql_real_escape_string($_POST['nachname'])."',
							strasse =  		'".mysql_real_escape_string($_POST['strasse'])."',
							hausnummer =  	'".mysql_real_escape_string($_POST['hausnummer'])."',
							plz =  			'".mysql_real_escape_string($_POST['plz'])."',
							ort =  			'".mysql_real_escape_string($_POST['ort'])."',
							show_normal =  	'".mysql_real_escape_string($_POST['show_normal'])."',
							full =  		'".mysql_real_escape_string($_POST['full'])."'
						WHERE  
							id = ".$id.";";
				mysql_query($sql) or die(mysql_error());
				
				$sql = "SELECT * FROM empfaenger WHERE id = ".$id." AND benutzer=".$user['id']." LIMIT 1;";
				$res = mysql_query($sql) or die(mysql_error());
				$eintrag = mysql_fetch_array($res);
				
				$script .= "top.location = top.location;";
			} 
	
			$name = $eintrag['vorname'];
			if ($eintrag['nachname']!='') {
				if ($name != '') $name .= " ";
				$name .= $eintrag['nachname'];
			}
				
			if ($eintrag['firmenname']!='') {
				if ($name != '') $name .= ", ";
				$name .= $eintrag['firmenname'];
			}	
			
			if ($eintrag['show_normal'] == '0') {
				$lines = explode("\n", $eintrag['full']);
				$name = $lines[0];
			}
		}

		/* Zwischen normal und full umschalten */  
		if (isset($_GET['show'])) {
			if ($_GET['show'] == 'full') {
				$eintrag['show_normal'] = '0';				
			}
			else
			{
				$eintrag['show_normal'] = '1';
			}
		} 
		
		/* Fallunterscheidungen normal und full*/ 
		$show_normal = ($eintrag['show_normal']==1);
		if ($show_normal) {
			$swap_link = createURL("adressbucheintrag", "id=".$id."&show=full");
			$script .= "adressbucheintrag_swap(true);";
			$swap_text = 'Auf direkte Adressfeld-Eingabe umschalten';
		}
		else
		{
			$swap_link = createURL("adressbucheintrag", "id=".$id."&show=normal");
			$script .= "adressbucheintrag_swap(false);";
			$swap_text = 'Auf normale Adressfeld-Eingabe umschalten';
		}
	
?>
<div id="header">
	<h1><?=$name?></h1>
</div>

<?php 
	if (strpos($_SERVER['HTTP_REFERER'], 'designer')) {
		echo '<div class="hspace20"></div><a class="orange_button" href="'.createURL("designer3adressbuch").'">&laquo; Zurück</a>';	
		echo '<div class="hspace20"></div><a class="orange_button" href="'.createURL("designer3adressbuch", "use=".$id).'">Als Empfänger-Adresse verwenden</a>';	
	}
?>

<form class="adressbuch_eintrag_form" action="<?=createURL("adressbucheintrag", "id=".$id)?>" method="post">


<a href="<?= $swap_link ?>" id="adressbucheintrag_swap"><?= $swap_text ?></a>
<input type="hidden" id="show_normal" name="show_normal" value="<?=$show_normal?'1':'0'?>" />
	
<?php // Hovertipps auskommentiert, sind überflüssig, da selbsterklärend!?>

	<div id="adressbucheintrag_normal" <?= $show_normal?'':'style="display:none"'?>>
		<div class="designer_form_row use_hover">
			<label for="firmenname">Firmenname</label>
			<input type="text" name="firmenname" id="firmenname" value="<?=$eintrag['firmenname']?>" />
			<?php //<div class="designer_form_tooltip"> ?>
				
			
		</div> 
	
		<div class="designer_form_row use_hover">
			<label for="anrede">Anrede </label>
			<input type="text" name="anrede" id="anrede" value="<?=$eintrag['anrede']?>" />
		
				
			
		</div> 
	
		<div class="designer_form_row use_hover">
			<label for="vorname">Vorname </label>
			<input type="text" name="vorname" id="vorname" value="<?=$eintrag['vorname']?>" />
			
				
			
		</div>
		 
		<div class="designer_form_row use_hover">
			<label for="nachname">Nachname</label>
			<input type="text" name="nachname" id="nachname" value="<?=$eintrag['nachname']?>" />
			
				
			
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="strasse">Straße / Postfach</label>
			<input type="text" name="strasse" id="strasse" value="<?=$eintrag['strasse']?>" />
			
			
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="hausnummer">Hausnummer</label>
			<input type="text" name="hausnummer" id="hausnummer" value="<?=$eintrag['hausnummer']?>" />
			
			
		</div> 
	
		<div class="designer_form_row use_hover">
			<label for="plz">Postleitzahl</label>
			<input type="text" name="plz" id="plz" value="<?=$eintrag['plz']?>" />
			
			
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="ort">Ort / Stadt</label>
			<input type="text" name="ort" id="ort" value="<?=$eintrag['ort']?>" />
			
		</div> 
	</div>
	
	<div <?= $show_normal?'style="display:none"':''?> id="adressbucheintrag_full" class="designer_form_row use_hover designer_form_row_tall">
		<label for="full">Adressfeld</label><br />
		<textarea name="full" id="full" class="full_width"><?=$eintrag['full']?></textarea>
		

		<div style="clear:both;"></div>
	</div>
	
	<div class="hspace20"></div>
	<input type="submit" name="submit" class="register_submit" value="Speichern &raquo;" /> 
</form>

<?php } ?>