<?php 
	/* Diese Datei definiert alle Felder eines Briefes und legt erlaubte Typ, Name in der Datenbank, 
	 * erlaubte Werte, Default-Werte und Beispiel-Werte fest */ 
	
	$field_rules = array(
		"design" => array (
			"step" => 1,
			"type" => "ENUM",
			"enum" => array ("classic", "modern", "blau", "formatb", "post"),
			"default" => "classic",
			"empty" => "classic",
			"user" => "design"
			
		),
		"letter_type" => array (
			"step" => 1,
			"type" => "ENUM",
			"enum" => array ("business", "private"),
			"default" => "business",
			"empty" => "business",
			"user" => "type"
			
		),	
		"showFensterLine" => array (
			"step" => 1,
			"type" => "ENUM",
			"enum" => array ("1", "0"),
			"default" => "1",
			"empty" => "1",
			"checkbox" => true,
			"user" => "fenster"
		),		
		"showFalzLine" => array (
			"step" => 1,
			"type" => "ENUM",
			"enum" => array ("1", "0"),
			"default" => "1",
			"empty" => "1",
			"checkbox" => true,
			"user" => "falz"
		),		
		"header"=> array (
			"step" => 1,
		 	"required" => false,
			"user" => "logo"				
		),		
		
		// Absender
		
		"absender_firmenname" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "",
			"user" => "firmenname"		
		),		
		"absender_anrede" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "",
			"user" => "anrede"			
		),		
		"absender_vorname" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "Max",
			"user" => "vorname"			
		),		
		"absender_nachname" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "Mustermann",
			"user" => "nachname"		
		),		
		"absender_strasse" => array (
			"step" => 2,
		 	"required" => true,	
			"default" => "",
			"empty" => "Mustergasse",
			"user" => "strasse"		
		),		
		"absender_hausnummer" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "",
			"user" => "hausnummer"			
		),		
		"absender_plz" => array (
			"step" => 2,
		 	"required" => true,	
			"default" => "",
			"empty" => "12345",
			"user" => "plz"			
		),		
		"absender_ort" => array (
			"step" => 2,
		 	"required" => true,	
			"default" => "",
			"empty" => "Musterhausen",
			"user" => "ort"			
		),
		
		// Bezugszeichenzeile
		
		"bzz_use" => array (
			"step" => 2,
			"type" => "ENUM",
			"enum" => array ("no", "bzz", "inf"),
			"default" => "bzz",
			"empty" => "bzz",
			"user" => "use_bzz"	
		),	
		"bzz_ihrzeichen" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "ABC 2000-01-01"		
		),
		"bzz_unserzeichen" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "ABC 02-01-00"		
		),
		"bzz_name" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "Max Mustermann",
			"user" => "name"			
		),
		"bzz_telefon" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "",
			"user" => "telefon"		
		),
		"bzz_fax" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "",
			"user" => "fax"		
		),
		"bzz_email" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "mustermann@musterfirma.de",
			"user" => "email"		
		),
		"bzz_internet" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "",
			"empty" => "http://www.musterfirma.de",
			"user" => "internet"		
		),
		"bzz_datum" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => date("d. m. Y"),
			"empty" => date("d. m. Y")	
		),
		
		// Geschäftsangaben
		
		"ga1" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "Firma Mustermann GmbH\nMusterstraße 1\n12345 Musterhausen\nDeutschland",
			"empty" => ""	
		),
		"ga2" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "Telefon: 012/3456789\nFax: 012/3456789\nInternet: www.musterfirma.de\nE-Mail: info@musterfirma.de",
			"empty" => ""
		),
		"ga3" => array (
			"step" => 2,
		 	"required" => false,	
			"default" => "Bank Musterhausen\nBLZ 12345678\nKonto 98765432\nUSt-IdNr.: DE123456789",
			"empty" => ""
		),
		
		// Empfänger
		
		"empfaenger_firmenname" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => ""		
		),		
		"empfaenger_anrede" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => ""		
		),		
		"empfaenger_vorname" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => "Erika"		
		),		
		"empfaenger_nachname" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => "Musterfrau"		
		),		
		"empfaenger_strasse" => array (
			"step" => 3,
		 	"required" => true,	
			"default" => "",
			"empty" => "Musterstraße"		
		),		
		"empfaenger_hausnummer" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => "1"		
		),		
		"empfaenger_plz" => array (
			"step" => 3,
		 	"required" => true,	
			"default" => "",
			"empty" => "54321"		
		),		
		"empfaenger_ort" => array (
			"step" => 3,
		 	"required" => true,	
			"default" => "",
			"empty" => "Musterstadt"		
		),
		"empfaenger_show_normal" => array (
			"step" => 3,
			"type" => "ENUM",
			"enum" => array ("1", "0"),
			"default" => "1",
			"empty" => "1"
		),	
		"empfaenger_full" => array (
			"step" => 3,
		 	"required" => false,	
			"default" => "",
			"empty" => ""		
		),
		
		
		// Betreff & Text

		"ortdatum" => array (
			"step" => 4,
		 	"required" => true,	
			"default" => "[Ort], den ".date("d. m. Y")	,
			"empty" => "[Ort], den ".date("d. m. Y")	
		),
		"betreff" => array (
			"step" => 4,
		 	"required" => true,	
			"default" => "",
			"empty" => "Kündigung meines Abonnement"		
		),
		"text" => array (
			"step" => 4,
		 	"required" => true,	
			"default" => "",
			"empty" => "Sehr geehrte Damen und Herren,
 
hiermit mache ich von meinem vertraglich zugesicherten Kündigungsrecht Gebrauch und kündige das Abo 12345 ihrer Zeitschrift fristgerecht zum nächstmöglichen Termin. 
 
Zum Zeitpunkt des Wirksamwerdens dieser Kündigung und darüber hinaus widerrufe ich hiermit ebenfalls die Ihnen erteilte Einzugsermächtigung für Konto (Nummer, BLZ, Name der Bank).
 
Bitte bestätigen Sie mir die Kündigung sowie das Datum, an dem Sie die Lieferung einstellen, schriftlich.
 
Mit freundlichen Grüßen,
Max Mustermann"		
		),
		
	); 

?>