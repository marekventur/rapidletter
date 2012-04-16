<?php 
	/* Die Admin-Bereich-Seite */
	$title = "Admin-Bereich";
	if ($user['isadmin']!=1) {
		header("Location: ".createURL("403")); 
		exit;
	}
	if (isset($_GET['reset'])) {
		echo "Ätsch, das geht hier nicht!";
		/*
		mysql_query("truncate table benutzer;") or die(mysql_error());
		mysql_query("truncate table briefe;") or die(mysql_error());
		mysql_query("truncate table empfaenger;") or die(mysql_error());
		mysql_query("truncate table textbausteine;") or die(mysql_error());
		mysql_query("truncate table vorlagen;") or die(mysql_error());
		mysql_query("INSERT INTO benutzer (password, email, vorname, isadmin) VALUES (MD5('admin'), 'admin@admin.de', 'Admin', '1');") or die(mysql_error());
		*/
	}
	if (isset($_GET['act'])) {
		$sql = "UPDATE briefe SET showpublic=1 WHERE id='".mysql_real_escape_string($_GET['act'])."';";
		mysql_query($sql) or die(mysql_error());
	}
	if (isset($_GET['deact'])) {
		$sql = "UPDATE briefe SET showpublic=0 WHERE id='".mysql_real_escape_string($_GET['deact'])."';";
		mysql_query($sql) or die(mysql_error());
	}
	
?>

<h1>Admin-Bereich</h1>
<?php  /* 
<h2>Datenbank zurücksetzen</h2>
<a href="<?=createURL("admin", "reset=1")?>" class="orange_button">Datenbank zurücksetzen</a>
<div class="hspace20"></div>
 */ ?>

<h2>Musterbriefe freigeben</h2>

<?php 
	
	$sql = "SELECT * FROM briefe WHERE ispublic=1  LIMIT 10;";
	
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($res)){
		echo '<div class="icon_with_text rounded_grey_border">
		<div class="icon icon_letter"></div><a href="'.createURL("brief", "id=".$row['uid']).'">'.
		html_entities($row['titel']).
		'</a><div class="gray">'.nl2br(html_entities($row['beschreibung'])).'</div>
		
		<div class="clear_both"></div>';
		
		if ($row['showpublic']) {
			echo '<span style="color: green;">AKTIVIERT</span> (<a href="'.createURL("admin", "deact=".$row['id']).'">Deaktivieren</a>)';
		} 
		else
		{
			echo '<span style="color: red;">DEAKTIVIERT</span> (<a href="'.createURL("admin", "act=".$row['id']).'">Aktivieren</a>)';
		}
		
		echo '<div class="clear_both"></div></div>';
	}
	

?>
