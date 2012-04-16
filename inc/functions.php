<?php

include PATH."inc/functions_static.php";

/* URL für bestimmte Seite erzeugen */
function createURL($page="index", $parameter="") {
	if ($page == "index")
		return URL;
	$parameter = str_replace(array('=', '&'), array('_', '_'), $parameter);
	return URL."/".$page.(($parameter=='')?"":"_".urlencode($parameter));
}

/* POST-Daten im Designer weiterverarbeiten */
function designer_handle_post($designer_nr) {
	global $field_rules;
	
	/* Wenn POST-Daten vorhanden... */
	if (count($_POST)>0) {
		/* ...gehe durch alle Felder */
		foreach ($field_rules as $field => $rule) {
			/* Wenn das Feld zu dem Schritt passt */
			if ($designer_nr == $rule['step']) {
				if (isset($rule['checkbox'])) {
					/* Falls das Feld durch einen Checkbox definiert wird */
					$_SESSION[$field] =	(isset($_POST[$field]))?"1":"0";
				}
				else
				{
					/* Falls das Feld durch ein Input definiert wird */
					if (isset($_POST[$field]))
						$_SESSION[$field] = $_POST[$field];
				}
			}
		}
		
		/* Der Brief hat sich verändert */
		letter_has_changed();
	}
	
	/* Brief auf Vilidität prüfen */
	checkLetter();
}	

/* Funktion, um festzuhalten dass sich der Brief verändert hat */
function letter_has_changed() {
	$_SESSION['changed_since_post'] = true	;
	$_SESSION['price_post'] = 0;
}

/* Brief anlgen, falls noch nicht in der aktuellen Session vorhanden */
function initLetter() {
	global $field_rules;
	global $user;
	global $user_is_logged_in;
	
	if (!isset($_SESSION['uid']))
		$_SESSION['uid'] = uniqid();
	
	foreach ($field_rules as $field => $rule)
		if (!isset($_SESSION[$field])) {
			/* falls der User registriert ist können Daten aus der DB übernommen werden, ansonsten nur Default-Werte */
			if (($user_is_logged_in) && (isset($rule['user']))) {
				$_SESSION[$field] = $user[$rule['user']];	
				if ($field == 'header') {
					$_SESSION['headerWidth'] = $user['logo_width'];
					$_SESSION['headerHeight'] = $user['logo_height'];
				}	
			}
			else
			{
				if (isset($rule['default']))
					$_SESSION[$field] = $rule['default'];
				else
					$_SESSION[$field] = '';
			}		
		}

}

/* Falls Session-Eintrag nicht mit einem Wert im Array übereinstimmt: Mit erstem Wert anlegen */
function checkSessionVar($key, $array) {
	if (!in_array($_SESSION[$key], $array))
		$_SESSION[$key] = $array[0];
}

/* Brief validieren */
function checkLetter() {
	global $field_rules;
	
	foreach ($field_rules as $field => $rule) {
		if ($rule['type'] == "ENUM")
			checkSessionVar($field, $rule['enum']);
	}
}

/* Session-Wert auslesen (abhängig von aktuellem Designerschritt) */
function getSessionVarEmpty($key) {
	global $field_rules;
	if (($_SESSION[$key] == '') && (isset($field_rules[$key]['empty'])) && ($_SESSION['designer_nr']<$field_rules[$key]['step'])) 
		return $field_rules[$key]['empty'];	
	return $_SESSION[$key];

}

/* Ist die Bild-Extension erlaubt? */
function isAllowedExtension($fileName) {
	return in_array(getExtension($fileName), array("jpg", "jpeg", "png", "gif"));
}

/* Extension auslesen */
function getExtension($fileName) {
	return end(explode(".", $fileName));
}

/* Bilder-Upload durchführen */
/* isuser: Gibt an, ob es ein Userprofil-Upload ist oder ein Designer-Upload*/
function handleUploadLogo($isuser=false) {
	global $user;		

	/* Kontrollieren, ob ein Upload vorliegt */
	if (isset($_FILES["letter_logo_upload"])) {
		/* Ist die extension erlaubt? */
		if (isAllowedExtension($_FILES["letter_logo_upload"]["name"])) {
			/* Dateiname festlegen  */
			if ($isuser)
				$name = 'user_'.$user['id'];			
			else
				$name = $_SESSION['uid'];
				
			/* Pfad festlegen */	
			$plain = PATH."uploads/logo/plain_" .$_SESSION['uid'].".".getExtension($_FILES["letter_logo_upload"]["name"]);
				
			/* Datei dahin verschieben */
			move_uploaded_file($_FILES["letter_logo_upload"]["tmp_name"],$plain);
			
			/* Bild öffnen und Größe auslesen */
			$fg = new imagick($plain);
			$fg->setImageFormat( "png" );
			$d = $fg->getImageGeometry();
			if ($isuser) {
				$user['logo_width'] = $d['width'];
				$user['logo_height'] = $d['height'];
			}
			else
			{
				$_SESSION['headerWidth'] = $d['width'];
				$_SESSION['headerHeight'] = $d['height'];
			}
			
			/* Alpha-Kanal vermeiden */
			$im=$fg->clone();
			$im->newImage( $d['width'], $d['height'], "red", "png" );
			$im->setImageBackgroundColor( new ImagickPixel( 'black' ) );
			$im->setImageDepth(8);
			$im->compositeImage( $fg, Imagick::COMPOSITE_OVER, 0, 0 );
				
			/* Abspeichern */
			$im->writeImage(PATH."uploads/logo/big_" . $name .".png");
			$im->scaleImage(150, 150, true);
			$im->writeImage(PATH."uploads/logo/small_" . $name.".png");
			
			/* Originaldatei löschen */
			unlink($plain);
				
			/* Bei Designerupload: In Session speichern*/
			if (!$isuser)
				$_SESSION['header'] = $_SESSION['uid'];
				
			/* Bild in DB übertragen */
			if ($isuser) {
				static_upload("uploads/logo/big_" . $name .".png");	
				static_upload("uploads/logo/small_" . $name.".png");	
			}
			else
			{
				static_upload("uploads/logo/big_" . $name .".png", 30*24*60*60);	
				static_upload("uploads/logo/small_" . $name.".png", 30*24*60*60);
			}
			
			return $name;
			
		}
	}
	return "";
}

/* E-Mail-Adresse validieren */
/* Function by http://www.linuxjournal.com/article/9585 */
function check_email_address($email) {
	// First, we check that there's one @ symbol,
	// and that the lengths are right.
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters
		// in one section or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if
			(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
			$local_array[$i])) {
			return false;
		}
	}
	// Check if domain is IP. If not,
	// it should be valid domain name
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if
				(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",
				$domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

/* Brief in der DB abspeichern */
function saveLetter($user_id, $isPublicTemplate=false, $empfaenger=true, $absender=true, $titel="", $beschr="", $use=false) {

    $design = "'".mysql_real_escape_string($_SESSION['design'])."'";
    $letter_type = "'".mysql_real_escape_string($_SESSION['letter_type'])."'";
    $showFensterLine = mysql_real_escape_string($_SESSION['showFensterLine']);
    $showFalzLine = mysql_real_escape_string($_SESSION['showFalzLine']);
    $header = "'".mysql_real_escape_string($_SESSION['header'])."'";
    $absender_firmenname = $absender?"'".mysql_real_escape_string($_SESSION['absender_firmenname'])."'":'NULL';
    $absender_anrede = $absender?"'".mysql_real_escape_string($_SESSION['absender_anrede'])."'":'NULL';
    $absender_vorname = $absender?"'".mysql_real_escape_string($_SESSION['absender_vorname'])."'":'NULL';
    $absender_nachname = $absender?"'".mysql_real_escape_string($_SESSION['absender_nachname'])."'":'NULL';
    $absender_strasse = $absender?"'".mysql_real_escape_string($_SESSION['absender_strasse'])."'":'NULL';
    $absender_hausnummer = $absender?"'".mysql_real_escape_string($_SESSION['absender_hausnummer'])."'":'NULL';
    $absender_plz = $absender?"'".mysql_real_escape_string($_SESSION['absender_plz'])."'":'NULL';
    $absender_ort = $absender?"'".mysql_real_escape_string($_SESSION['absender_ort'])."'":'NULL';
    $bzz_use = $absender?"'".mysql_real_escape_string($_SESSION['bzz_use'])."'":'NULL';
    $bzz_ihrzeichen = $absender?"'".mysql_real_escape_string($_SESSION['bzz_ihrzeichen'])."'":'NULL'; 
    $bzz_unserzeichen = $absender?"'".mysql_real_escape_string($_SESSION['bzz_unserzeichen'])."'":'NULL';
    $bzz_name = $absender?"'".mysql_real_escape_string($_SESSION['bzz_name'])."'":'NULL';
    $bzz_telefon = $absender?"'".mysql_real_escape_string($_SESSION['bzz_telefon'])."'":'NULL'; 
    $bzz_fax = $absender?"'".mysql_real_escape_string($_SESSION['bzz_fax'])."'":'NULL';
    $bzz_email = $absender?"'".mysql_real_escape_string($_SESSION['bzz_email'])."'":'NULL';
    $bzz_internet = $absender?"'".mysql_real_escape_string($_SESSION['bzz_internet'])."'":'NULL'; 
    $bzz_datum = $absender?"'".mysql_real_escape_string($_SESSION['bzz_datum'])."'":'NULL';
    $ga1 = $absender?"'".mysql_real_escape_string($_SESSION['ga1'])."'":'NULL'; 
    $ga2 = $absender?"'".mysql_real_escape_string($_SESSION['ga2'])."'":'NULL';
    $ga3 = $absender?"'".mysql_real_escape_string($_SESSION['ga3'])."'":'NULL';
    $empfaenger_firmenname = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_firmenname'])."'":'NULL'; 
    $empfaenger_anrede = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_anrede'])."'":'NULL'; 
    $empfaenger_vorname = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_vorname'])."'":'NULL';
    $empfaenger_nachname = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_nachname'])."'":'NULL';
    $empfaenger_strasse = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_strasse'])."'":'NULL';
    $empfaenger_hausnummer = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_hausnummer'])."'":'NULL';
    $empfaenger_plz = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_plz'])."'":'NULL';
    $empfaenger_ort = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_ort'])."'":'NULL';
    $empfaenger_show_normal = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_show_normal'])."'":'1';
    $empfaenger_full = $empfaenger?"'".mysql_real_escape_string($_SESSION['empfaenger_full'])."'":"''";
    $ortdatum = "'".mysql_real_escape_string($_SESSION['ortdatum'])."'";
    $betreff = "'".mysql_real_escape_string($_SESSION['betreff'])."'";
    $text = "'".mysql_real_escape_string($_SESSION['text'])."'";
    $uid= uniqid();
	
    $sql = "INSERT INTO briefe 
    	(
    		benutzer,
    	
    		design, letter_type, showFensterLine, showFalzLine, header, 
    		
    		absender_firmenname, absender_anrede, absender_vorname, absender_nachname, 
    		absender_strasse, absender_hausnummer, absender_plz, absender_ort,
    		
    		bzz_use, bzz_ihrzeichen, bzz_unserzeichen, bzz_name, bzz_telefon, bzz_fax, 
    		bzz_email, bzz_internet, bzz_datum,
    		
    		ga1, ga2, ga3,
    		
    		empfaenger_firmenname, empfaenger_anrede, empfaenger_vorname, empfaenger_nachname, 
    		empfaenger_strasse, empfaenger_hausnummer, empfaenger_plz, empfaenger_ort, empfaenger_show_normal, empfaenger_full,
    		
    		betreff, text, ortdatum,

    		titel, beschreibung, ispublic, usepublic,
    		
    		uid
    	)
    	VALUES
    	(".
    		$user_id.",".
    		
    		$design.",".$letter_type.",".$showFensterLine.",".$showFalzLine.",".$header.",".
    
   			$absender_firmenname.",".$absender_anrede.",".$absender_vorname.",".$absender_nachname.",".
   			$absender_strasse.",".$absender_hausnummer.",".$absender_plz.",".$absender_ort.",".
   			
   			$bzz_use.",".$bzz_ihrzeichen.",".$bzz_unserzeichen.",".$bzz_name.",".$bzz_telefon.",".$bzz_fax.",".
   			$bzz_email.",".$bzz_internet.",".$bzz_datum.",".
   			
   			$ga1.",".$ga2.",".$ga3.",".
   			
   			$empfaenger_firmenname.",".$empfaenger_anrede.",".$empfaenger_vorname.",".$empfaenger_nachname.",".$empfaenger_strasse.",".
   			$empfaenger_hausnummer.",".$empfaenger_plz.",".$empfaenger_ort.",".$empfaenger_show_normal.",".$empfaenger_full.",".
   			
   			$betreff.",".$text.",".$ortdatum.",".
   			
   			"'".mysql_real_escape_string($titel)."','".mysql_real_escape_string($beschr)."',".($isPublicTemplate?"1":"0").",".($use?"1":"0").",".
   			
   			"'".$uid."'".
    	");";
   			
	
    	mysql_query($sql) or die(mysql_error());
    	
    	return $uid;
    	
    	
}

/* Convenience function für htmlentities in UTF8 */
function html_entities($text) {
	return htmlentities($text, ENT_COMPAT, 'UTF-8');
}

/* Briefvorschaubild abspeichern */
function saveLetterPNG($uid, $sabsender=true, $sempfaenger=true) {
	/* Speicherort festlegen */
	$file = "img/letter/".$uid.".png";
	
	/* Briefdesign includieren */
	require_once(PATH."letter/letter_".getSessionVarEmpty('design').".php");

	/* Briefinstanz erzeugen */
	$letter = new Letter();
	
	/* Lade Brief aus Session */
	initLetterFromSession($letter, $sabsender, $sempfaenger);
	
	/* Brief als Bild abspeichern */
	$letter->SaveImage(1, 296, 420, $file);
	
	/* Bild in DB übertragen */
	static_upload($file);

}

/* Brief aus Datenbank in die Session laden */
function loadLetter($letter_id) {
	global $user;
	if (isset($user['id'])) 
		$user_id = $user['id'];
	else
		$user_id = -1;
	
	$sql = "SELECT * FROM briefe WHERE id=".($letter_id*1)." AND ((benutzer = ".$user_id.") OR (ispublic = 1)) LIMIT 1;";

	$res = mysql_query($sql) or die(mysql_error());
	if($row = mysql_fetch_array($res)){
		foreach ($row as $key => $value) {
			if (!is_numeric($key)) {	
				$_SESSION[$key] = $value;
			}
		}
		$_SESSION['uid'] = uniqid();	
		return true;
	} 
	return false;
		
}

/* Briefklasse mit Session-Daten füllen */
function initLetterFromSession($letter, $sabsender=true, $sempfaenger=true, $generate=true) {
	
	// Design und Typ
	$letter->showFensterLine = (getSessionVarEmpty('showFensterLine') == '1');
	$letter->showFalzLine = (getSessionVarEmpty('showFalzLine') == '1');
	if ((getSessionVarEmpty('header')!='') && ($sabsender)) {
		$letter->header = 'uploads/logo/big_'.getSessionVarEmpty('header').'.png';
		$letter->headerImageWidth = $_SESSION['headerWidth'];
		$letter->headerImageHeight = $_SESSION['headerHeight'];
	}	
	if (getSessionVarEmpty('letter_type') == 'private') {
		$letter->showBzz = false;
		$letter->ga = false;
	}
	else
	{
		$letter->showBzz = true;
		$letter->ga = true;
	}
	
	// Absender - Absenderzeile
	if ($sabsender) {
		$absender = "";
		if (getSessionVarEmpty('absender_firmenname') != '') $absender = getSessionVarEmpty('absender_firmenname').', ';
		if (getSessionVarEmpty('absender_anrede') != '') $absender .= getSessionVarEmpty('absender_anrede').' ';
		if (getSessionVarEmpty('absender_vorname') != '') $absender .= getSessionVarEmpty('absender_vorname').' ';
		if (getSessionVarEmpty('absender_nachname') != '') $absender .= getSessionVarEmpty('absender_nachname').', ';
		$absender .= getSessionVarEmpty('absender_strasse');
		if (getSessionVarEmpty('absender_hausnummer') != '') $absender .= ' '.getSessionVarEmpty('absender_hausnummer');
		$absender .= ', ';
		$absender .= getSessionVarEmpty('absender_plz').' ';
		$absender .= getSessionVarEmpty('absender_ort');
	}
	else
	{
		$absender = "Max Musterman, Mustergasse 1, 12345 Musterstadt";
	}
	
	$letter->absender = $absender;
	
	if ($sabsender) {
		// Absender BZZ
		
		if (getSessionVarEmpty('bzz_use') == 'bzz') {
		
			$letter->bzz1Text = getSessionVarEmpty('bzz_ihrzeichen');
			$letter->bzz2Text = getSessionVarEmpty('bzz_unserzeichen');
			
			$letter->bzz3Name = "";
			$letter->bzz3Text = "";
			
			if (getSessionVarEmpty('bzz_telefon') != '') {
				$letter->bzz3Name = "Telefon";
				$letter->bzz3Text = getSessionVarEmpty('bzz_telefon');
			}
				
			if (getSessionVarEmpty('bzz_name') != '') {
				if ($letter->bzz3Name != '') {
					$letter->bzz3Name .= ", ";
					$letter->bzz3Text .= ", ";
				}
				$letter->bzz3Name = "Name";
				$letter->bzz3Text = getSessionVarEmpty('bzz_name');
			}
			
			$letter->bzz4Text = getSessionVarEmpty('bzz_datum');
		}
		else
		{
			$letter->showBzz = false;
		}	
		
		// Absender GA
		
		$letter->ga1Text = getSessionVarEmpty('ga1');
		$letter->ga2Text = getSessionVarEmpty('ga2');
		$letter->ga3Text = getSessionVarEmpty('ga3');
	}
	else
	{
		$letter->ga1Text = '';
		$letter->ga2Text = '';
		$letter->ga3Text = '';
	}
	
	// Empfänger
	
	$letter->sendungsart = "";
	
	if ($sempfaenger) {
		$letter->empfaengername = getSessionVarEmpty('empfaenger_firmenname'); 
		if ($letter->empfaengername != '') $letter->empfaengername .= "\n";
		if (getSessionVarEmpty('empfaenger_anrede') != '') $letter->empfaengername .= getSessionVarEmpty('empfaenger_anrede').' ';
		if (getSessionVarEmpty('empfaenger_vorname') != '') $letter->empfaengername .= getSessionVarEmpty('empfaenger_vorname').' ';
		if (getSessionVarEmpty('empfaenger_nachname') != '') $letter->empfaengername .= getSessionVarEmpty('empfaenger_nachname');
		$letter->strasse = getSessionVarEmpty('empfaenger_strasse').' '.getSessionVarEmpty('empfaenger_hausnummer'); 
		$letter->plzPre = "";
		$letter->plz = getSessionVarEmpty('empfaenger_plz');
		$letter->ort = getSessionVarEmpty('empfaenger_ort');
		$letter->land = ""; 
		$letter->empfaenger_show_normal = (getSessionVarEmpty('empfaenger_show_normal') == '1');
		$letter->empfaenger_full = getSessionVarEmpty('empfaenger_full');
	}
	
	// Ort und Datum
	if (getSessionVarEmpty('bzz_use') != 'bzz') {
		if (getSessionVarEmpty('ortdatum') != "") {
			$letter->ortdatum = getSessionVarEmpty('ortdatum');
			$letter->showortdatum = true;
		}	
	}	
		
	
	// Betreff und Text
	$letter->betreff = getSessionVarEmpty('betreff');
	$letter->text = getSessionVarEmpty('text');
	
	if ($generate) 
		$letter->Generate(); 
	
	return $letter;
}

/* Funktion für zukünftige Erweiterung (noch ohne Zweck) */
function calculate_price_lvin($price) {
	return round(($price + 30) * 1.1 + 10);
}

/* Eindeutigen Hash aus aktuellem Session-Brief generieren */
function letter_hash() {
	global $field_rules;
	
	$res = "";
	foreach ($field_rules as $field => $rule) 
		$res .= '####'.$_SESSION[$field];

	return md5($res);
}



?>