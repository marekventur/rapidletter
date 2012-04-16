<?php
	/* Diese Seite dient dem Benutzer zum Ändern seiner Design-Standardeinstellungen */

	$title = "Ihr Profil";
	
	
	if (!$user_is_logged_in) {
		include ('components/login_error.php');
	}
	else
	{
		include ('components/profil_left.php');
		
		if (isset($_POST['submit'])) {
		
			$logo = handleUploadLogo(true);
			if ($logo == "") $logo = $user['logo'];
			$sql = "UPDATE  
						benutzer 
					SET  
						design =  		'".mysql_real_escape_string($_POST['design'])."',
						type =  		'".mysql_real_escape_string($_POST['type'])."',
						fenster =  		".(isset($_POST['fenster'])?"1":"0").",
						falz =  		".(isset($_POST['falz'])?"1":"0").",
						logo =  		'".mysql_real_escape_string($logo)."',
						logo_width = 	".$user['logo_width'].",
						logo_height = 	".$user['logo_height']."
					WHERE  
						id = ".$user['id'].";";
			mysql_query($sql) or die(mysql_error());
			
			$sql = "SELECT * from benutzer where id='".mysql_real_escape_string($_SESSION['user'])."' LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			if(!$user = mysql_fetch_array($res)) {
				unset($_SESSION['user']); 
				$user_is_logged_in = false;
			}
			
			
		}
		
		if (isset($_GET['logo'])) {
			$sql = "UPDATE  
						benutzer 
					SET  
						logo =  		'',
						logo_width = 	0,
						logo_height = 	0
					WHERE  
						id = ".$user['id'].";";
			mysql_query($sql) or die(mysql_error());
			
			$sql = "SELECT * from benutzer where id='".mysql_real_escape_string($_SESSION['user'])."' LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			if(!$user = mysql_fetch_array($res)) {
				unset($_SESSION['user']);
				$user_is_logged_in = false;
			}
		}
		
		/* Logo vorhanden? */
		static_exists('uploads/logo/small_'.$user['logo'].'.png');
	
?>

<div class="half_right">
	<h2>Ihr Standartdesign & ihr Logo</h2>
	
	<form enctype="multipart/form-data" action="<?php echo createURL("profildesign"); ?>" method="post">
		
		<div class="designer_form_row use_hover">
			<label for="design">Briefdesign</label>
			<select name="design" id="design">
				<option value="classic" <?=(($user['design']=="classic")?"selected=\"selected\"":"")?>>Classic</option>
				<option value="modern" <?=(($user['design']=="modern" )?"selected=\"selected\"":"")?>>Modern</option>
				<option value="blau" <?=(($user['design']=="blau" )?"selected=\"selected\"":"")?>>Blau</option>
				<option value="formatb" <?=(($user['design']=="formatb" )?"selected=\"selected\"":"")?>>Format B</option>
			</select>
			<div class="designer_form_tooltip">
	Hier können Sie zwischen verschiedenen Templates als Vorlage wählen.
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="type">Briefart</label>
			<select name="type" id="type">
				<option value="business" <?=(($user['type']=="business")?"selected=\"selected\"":"")?>>Geschäftsbrief</option>
				<option value="private" <?=(($user['type']=="private" )?"selected=\"selected\"":"")?>>Privatbrief</option>
			</select>
			<div class="designer_form_tooltip">
				Wählen Sie hier, ob Sie einen Geschäftsbrief oder einen privaten Brief schreiben wollen. Geschäftsbriefe müssen die 
				gesetzlich geforderten Pflichtangaben entsprechend der jeweiligen Gesellschaftsform führen.<br />
			</div>
		</div> 
		
		<div class="designer_form_row use_hover">
			<label for="fenster">Sichtfensterrahmen</label>
			<input type="checkbox" name="fenster" id="fenster" <?=(($user['fenster']=="1")?"checked=\"checked\"":"")?> />
			<div class="designer_form_tooltip">
				Wenn diese Option gewählt ist, werden die Ecken des Sichtfensters im Brief markiert. <br />
				<span class="gray">Dies kann hilfreich sein, um zu kontrollieren, ob der Brief richtig gefaltet wurde.</span>
			</div>
		</div> 	
		<div class="designer_form_row use_hover">
			<label for="falz">Falz- und Lochmakierungen</label> 
			<input type="checkbox" name="falz" id="falz" <?=(($user['falz']=="1")?"checked=\"checked\"":"")?> />
			<div class="designer_form_tooltip">
	Mit dieser Option können Sie Markierungen einfügen, die zur Orientierung beim Falten oder Lochen des Briefes dienen.			
			</div>
		</div> 	
		
		<div class="clear_both"></div>
		
		<div class="designer_form_row use_hover">
			<span class="label">Logo</span>
			<div class="designer_like_input">
				<?php if ($user['logo'] == "") {?>  
				Kein Logo gewählt.<br />
				<?php } else { ?>
				<img id="logo_preview" src="/uploads/logo/small_<?=$user['logo']?>.png" alt="Logo" />
				<a href="<?=createURL("profildesign", "logo=delete")?>">Logo löschen</a>
				<?php } ?>
			</div>
			<div class="designer_form_tooltip">
	Falls Sie über ein persönliches Logo verfügen, können Sie dieses hier einfügen.			
			</div>
					
		</div> 	
		
		<?php if ($user['logo'] == "") {?>  
		<input type="file" name="letter_logo_upload" id="letter_logo_upload" />
		<?php } ?>
		<div class="clear_both"></div>
		<input type="submit" name="submit" class="orange_button" value="Speichern &raquo;" />
	
	</form>

</div>
<div class="half_clear"></div> 
<?php } ?>