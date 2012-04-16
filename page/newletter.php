<?php 
	/* Dieses Script überschreibt den aktuellen Brief in der Session mit einem neuen Brief (evtl. auf Grundlage einer Vorlage) */
	$title = "Neuen Brief erstellen";
	
	function clearLetter() {
		global $field_rules;
		foreach ($field_rules as $field => $rule)
			unset($_SESSION[$field]);
		unset($_SESSION['designer_nr']);
		
		// Wurde seit der letzten Postpreisberechnung eine Änderung durchgeführt?
		$_SESSION['changed_since_post'] = true	;
		$_SESSION['price_post'] = 0;
	}
	
	if (isset($_GET['vorlage'])) {
		clearLetter();
		$_GET['vorlage'] = ($_GET['vorlage'] - 1 + 1) * 1;
		$sql = "SELECT betreff, text FROM vorlagen WHERE id = ".$_GET['vorlage']." LIMIT 1;";
		$res = mysql_query($sql) or die(mysql_error());
		if($row = mysql_fetch_array($res)){
			$_SESSION['betreff'] = $row['betreff'];
			$_SESSION['text'] = $row['text'];
		}
		
	}
	else
	{
		if (isset($_SESSION['design'])) 
			clearLetter();
		
		
	}
	
	header("Location: ".createURL("designer1")); 
	exit;
	
?>
