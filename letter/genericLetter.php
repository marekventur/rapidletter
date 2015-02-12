<?php
	/* Diese Datei stellt die Basisklasse eines Briefgenerators da. 
	 * Es leitet sich von einer PDF-Library ab, erweitert sie aber z.B. um Bildausgabe und den Designelementen eines normalen Briefes
	 * Alle Designs leiten sich ursprünglich von dieser Klasse ab.
	 * */
	require('fpdf.php');
	
	class GenericLetter extends FPDF
	{
		
		// Schrift
		public $font = "times";

		// Seitenmaße
		public $pageWidth = 210;
		public $pageHeight = 297;
		public $marginTop = 20; 
		public $marginLeft = 24.1;
		public $marginBottom = 20;
		public $marginRight = 18.1;
		
		// Kopfzeile
		public $header = "";
		public $headerImageWidth = 736;
		public $headerImageHeight = 375;
		public $headerTop = 7;
		public $headerHeight = 20;

		// Fensterfeld
		public $fensterLeft = 20;
		public $fensterTop = 27;
		public $fensterWidth = 85;
		public $fensterHeight = 45;
		public $showFensterLine = true;
		public $fensterLineLength = 2.5;
		public $empfaengerHeight = 40;	
		public $absenderHeight = 5;	
		public $absenderFontSize = 6;	
		public $empfaengerFontSize = 10;	
		public $empfaengerLineHeight = 5;	
		
		// Falz
		public $showFalzLine = true;
		
		// Betreff
		public $betreffFontSize = 10;
		public $betreffTop = 10;
		
		// Text
		public $textFontSize = 10;
		public $textLineHeight = 1.3;
		public $textTop = 105.5;
		
		// Falz- und Lochmarken
		public $markeLength = 5;
		public $marke1Top = 87; // 105
		public $marke2Top = 192; // 210
		public $marke3Top = 148.5;
		
		// Seitenangabe
		public $pageFontSize = 8;
		

		// Absender
		public $absender = "Max Mustermann, Mustergasse 1, 12345 Musterhausen";

		// Empfänger
		public $empfaenger_show_normal = true; // Empfänger aus Feldern zusammesetzen
		public $sendungsart = ""; // Einschreiben
		public $empfaengername = "Erika Musterfrau"; // Evtl. Zweizeilig
		public $strasse = "Musterstrasse 2"; // Postfach mit Nummer oder Straße und Hausnummer
		public $plzPre = "";
		public $plz = "54321";
		public $ort = "Muserhausen";
		public $land = ""; 
		public $empfaenger_full = "";
		
		

		// Bezugszeichenzeile
		public $showBzz = true;
		public $bzzHeight = 20;
		public $bzzFontSize1 = 8;
		public $bzzFontSize2 = 10;
		public $bzzLineHeight = 1.3;
		
		public $bzz1Top1 = 80.5;
		public $bzz1Top2 = 82.5;
		public $bzz1Left = 24.1;
		public $bzz1Name = "Ihr Zeichen, Ihre Nachricht";
		public $bzz1Text = "ABC 2005-04-09";

		public $bzz2Top1 = 80.5;
		public $bzz2Top2 = 82.5;
		public $bzz2Left = 74.9;  
		public $bzz2Name = "Unser Zeichen, unsere Nachricht";
		public $bzz2Text = "DJ";

		public $bzz3Top1 = 80.5;
		public $bzz3Top2 = 82.5;
		public $bzz3Left = 125.7;
		public $bzz3Name = "Telefon, Name";
		public $bzz3Text = "12345 Herr Mustermann";

		public $bzz4Top1 = 80.5;
		public $bzz4Top2 = 82.5;
		public $bzz4Left = 176.5;
		public $bzz4Name = "Datum";
		public $bzz4Text = "09.04.05";
		
		// Geschäftsangaben
		public $ga = true;
		public $gaFontSize = 8;
		public $gaLineCount = 4;
		public $gaLineHeight = 1.3;
		public $ga1Left = 24.1;
		public $ga1Text = "Firma Rapunzel GmbH\nSiegfriedstraße 17a\n98765 München\nDeutschland";        
		public $ga2Left = 83.1;
		public $ga2Text = "Telefon: 089/1234567890\nFax: 089/1234567891\nInternet: www.rapunzelgmbh.de\nE-Mail: info@rapunzelgmbh.de";
		public $ga3Left = 142.1;
		public $ga3Text = "Sparkasse München\nBLZ 23456789\nKonto 9878323\nUSt-IdNr.: DE123456789";

		// Ort & Datum
		public $showortdatum = false;
		public $ortdatum = "";
			
		// Inhalt
		public $betreff = "Kündigung meines Abonnement";
		public $text = "Sehr geehrte Damen und Herren,
 
hiermit mache ich von meinem vertraglich zugesicherten Kündigungsrecht Gebrauch und kündige das Abo 12345 ihrer Zeitschrift fristgerecht zum nächstmöglichen Termin. 
 
Zum Zeitpunkt des Wirksamwerdens dieser Kündigung und darüber hinaus widerrufe ich hiermit ebenfalls die Ihnen erteilte Einzugsermächtigung für Konto (Nummer, BLZ, Name der Bank).
 
Bitte bestätigen Sie mir die Kündigung sowie das Datum, an dem Sie die Lieferung einstellen, schriftlich.
 
Mit freundlichen Grüßen,
Max Mustermann";

		
		function Init() {
			$this->SetTitle($this->betreff, true);
			$this->SetSubject($this->betreff, true);
			$this->SetAuthor($this->absender, true);
			$this->SetCreator("rapidletter.de", true);
			
			$this->SetMargins($this->marginLeft, $this->marginTop, $this->marginRight);
			if ($this->ga == false)
				$gaLineCount = 0;
			else
				$gaLineCount = max(
					count(explode("\n",$this->ga1Text)),
					count(explode("\n",$this->ga2Text)),
					count(explode("\n",$this->ga3Text))
				);
		
			$this->SetAutoPageBreak(true , $this->marginBottom + 
										$this->PointToMM($this -> gaFontSize) * $this->gaLineHeight * $this->gaLineCount);
		}
		
		function PointToMM($pt) {
			return $pt * 0.35277;
		}
		
		
		
		

		function Header() {
			if ($this->PageNo() == 1) {
			
				// Kopfzeile
				if ($this->header != "") {
					if($this->headerImageHeight > 0)
						$width = $this->headerHeight * $this->headerImageWidth / $this->headerImageHeight;
					else
						$width = $this->headerHeight;
						
					static_exists($this->header);
					if (file_exists(PATH.$this->header)) {
						@$this->Image(PATH.$this->header,$this->pageWidth - $this->marginLeft - $width,$this->headerTop,$width,$this->headerHeight);
					}
				}
	
			
				// Absender
				$this->SetFont($this->font,'u',$this->absenderFontSize);
				$this->SetXY($this->fensterLeft+2.5, $this->fensterTop+ 2.5);
				$this->Cell($this->fensterWidth, $this->absenderHeight, utf8_decode($this->absender), 0);
				
				// Empfänger
				$this->SetFont($this->font,'',10);
				$this->SetXY($this->fensterLeft+2.5, $this->fensterTop+$this->absenderHeight + 2.5);
				if ($this->empfaenger_show_normal) {
				
					$empfaenger = $this->sendungsart."\n\n".
						$this->empfaengername."\n".
						$this->strasse."\n".
						$this->plzPre.(($this->plzPre=='')?'':'-').$this->plz.' '.$this->ort."\n".
						$this->land;
				}
				else
				{
					$empfaenger = "\n\n".$this->empfaenger_full;
				}		
				$this->MultiCell($this->fensterWidth, 4.23, utf8_decode($empfaenger), 0);
				
				// Rahmen
				if ($this->showFensterLine) {
					$this->SetDrawColor(0, 0, 0);
					
					$this->Line($this->fensterLeft, $this->fensterTop, $this->fensterLeft + $this->fensterLineLength, $this->fensterTop);
					$this->Line($this->fensterLeft, $this->fensterTop, $this->fensterLeft, $this->fensterTop + $this->fensterLineLength);
					
					$this->Line($this->fensterLeft + $this->fensterWidth, $this->fensterTop, $this->fensterLeft + $this->fensterWidth - $this->fensterLineLength, $this->fensterTop);
					$this->Line($this->fensterLeft + $this->fensterWidth, $this->fensterTop, $this->fensterLeft + $this->fensterWidth, $this->fensterTop + $this->fensterLineLength);
					
					$this->Line($this->fensterLeft, $this->fensterTop + $this->fensterHeight, $this->fensterLeft + $this->fensterLineLength, $this->fensterTop + $this->fensterHeight);
					$this->Line($this->fensterLeft, $this->fensterTop + $this->fensterHeight, $this->fensterLeft, $this->fensterTop + $this->fensterHeight - $this->fensterLineLength);
					
					$this->Line($this->fensterLeft + $this->fensterWidth, $this->fensterTop + $this->fensterHeight, $this->fensterLeft + $this->fensterWidth - $this->fensterLineLength, $this->fensterTop + $this->fensterHeight);
					$this->Line($this->fensterLeft + $this->fensterWidth, $this->fensterTop + $this->fensterHeight, $this->fensterLeft + $this->fensterWidth, $this->fensterTop + $this->fensterHeight - $this->fensterLineLength);
				}
				if ($this->showBzz) {
					// Bezugszeichenzeile 1
					$this->SetFont($this->font,'',$this->bzzFontSize1);
					
					$this->SetXY($this->bzz1Left, $this->bzz1Top1);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize1) * $this->bzzLineHeight, utf8_decode($this->bzz1Name), 0);
					
					$this->SetXY($this->bzz2Left, $this->bzz2Top1);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize1) * $this->bzzLineHeight, utf8_decode($this->bzz2Name), 0);
					
					$this->SetXY($this->bzz3Left, $this->bzz3Top1);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize1) * $this->bzzLineHeight, utf8_decode($this->bzz3Name), 0);
					
					$this->SetXY($this->bzz4Left, $this->bzz4Top1);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize1) * $this->bzzLineHeight, utf8_decode($this->bzz4Name), 0);
					
					// Bezugszeichenzeile 2
					$this->SetFont($this->font,'',$this->bzzFontSize2);
					
					$this->SetXY($this->bzz1Left, $this->bzz1Top2);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize2) * $this->bzzLineHeight, utf8_decode($this->bzz1Text), 0);
					
					$this->SetXY($this->bzz2Left, $this->bzz2Top2);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize2) * $this->bzzLineHeight, utf8_decode($this->bzz2Text), 0);
					
					$this->SetXY($this->bzz3Left, $this->bzz3Top2);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize2) * $this->bzzLineHeight, utf8_decode($this->bzz3Text), 0);
					
					$this->SetXY($this->bzz4Left, $this->bzz2Top2);
					$this->MultiCell(50, $this->PointToMM($this -> bzzFontSize2) * $this->bzzLineHeight, utf8_decode($this->bzz4Text), 0);
				}
				
			}
			else
			{
			
				$this->SetY($this->marginTop/2 - $this->PointToMM($this -> pageFontSize)/2 );
				$this->SetFont($this -> font,'',$this -> pageFontSize);
				$this->Cell(0,10,utf8_decode($this->betreff).' - Seite '.$this->PageNo(),0,0,'C');
				$this->SetY($this->marginTop);
			}
			
			// Falz- und Lochmarken
			if ($this->showFalzLine) {
				$this->SetDrawColor(127, 127, 127);
	
				$this->Line(0, $this->marke1Top, $this->markeLength, $this->marke1Top);
				$this->Line(0, $this->marke2Top, $this->markeLength, $this->marke2Top);
				$this->Line($this->markeLength, $this->marke3Top, $this->markeLength*2, $this->marke3Top);
			}
		}

		function Footer()
		{			
			if ($this->ga) {
				// Geschäftsangaben 1
				$top = $this->pageHeight - ($this->marginBottom/2 + $this->PointToMM($this -> gaFontSize) * $this->gaLineHeight * $this->gaLineCount);
				
				$this->SetFont($this->font,'',$this->bzzFontSize1);
					
				$this->SetXY($this->ga1Left, $top);
				$this->MultiCell($this->ga2Left - $this->ga1Left, $this->PointToMM($this -> gaFontSize) * $this->gaLineHeight, utf8_decode($this->ga1Text), 0);
				
				$this->SetXY($this->ga2Left, $top);
				$this->MultiCell($this->ga2Left - $this->ga1Left, $this->PointToMM($this -> gaFontSize) * $this->gaLineHeight, utf8_decode($this->ga2Text), 0);
				
				$this->SetXY($this->ga3Left, $top);
				$this->MultiCell($this->ga2Left - $this->ga1Left, $this->PointToMM($this -> gaFontSize) * $this->gaLineHeight, utf8_decode($this->ga3Text), 0);
			}	
			
			
		}

	

		function AddText()
		{
			$this->AddPage();

			// Setzte Position auf erste Zeile
			$this->SetXY($this->marginLeft, $this->textTop- ($this->showBzz?0:$this->bzzHeight));
			
			// Wenn OrtDatum gegeben, dieses Rechtsbündig ausgeben
			if ($this->showortdatum) {
				//$this->Write($this->PointToMM($this->textFontSize) * $this->textLineHeight, utf8_decode($this->ortdatum));
				$this->Cell(
					0,
					$this->PointToMM($this->textFontSize) * $this->textLineHeight, 
					utf8_decode($this->ortdatum),
					0,
					1,
					"R");

			}
			
			$this->SetFont($this->font,'b',$this->textFontSize);
			
			$this->Write($this->PointToMM($this->textFontSize) * $this->textLineHeight, utf8_decode($this->betreff));
			
			$this->SetFont($this->font,'',$this->textFontSize);
			$this->Ln();
			$this->Ln();
			$this->MultiCell($this->pageWidth - $this->marginLeft - $this->marginRight,
							$this->PointToMM($this->textFontSize) * $this->textLineHeight, 
							utf8_decode(chop($this->text)));
			
			
			/*$this->WriteHTML($html);*/
			
			/*$this->MultiCell($this->pageWidth - $this->marginLeft - $this->marginRight, 
							$this->PointToMM($this->textFontSize) * $this->textLineHeight, 
							utf8_decode($this->text));*/

		}
		
		function AddGrid() {
			$this->SetDrawColor(200, 200, 200);
			for ($x = 10; $x<210; $x+=10) {
				$this->Line($x, 0, $x, 297);
			}
			for ($y = 10; $y<297; $y+=10) {
				$this->Line(0, $y, 210, $y);
			}
		}
		
		function Generate() {
			$this->Init();
			$this->AddText();
		}
		
		function GetPageCount() {
			return $this->PageNo();
		}
		
		function OutputImage($page, $width, $height) {
			$file = PATH.'temp/t'.uniqid().'.pdf';
			while (!file_exists ($file))
				$this->Output($file, 'f');
			$im = new imagick( $file.'['.($page-1).']' );
			unlink($file);
			$im->scaleImage($width, $height, true);
			$im->setImageFormat( "png" );
			$im->setImageBackgroundColor('white');
			$im = $im->flattenImages();
			header( "Content-Type: image/png" );
			echo $im;
		}
		
		function SaveImage($page, $width, $height, $filepng) {
			$file = PATH.'temp/t'.uniqid().'.pdf';
			while (!file_exists ($file))
				$this->Output($file, 'f');
			$im = new imagick( $file.'['.($page-1).']' );
			unlink($file);
			$im->scaleImage($width, $height, true);
			$im->setImageFormat( "png" );
			
			$im->writeImage($filepng);
		}
		
		function SaveLocal() {
			$file = PATH.'temp/t'.uniqid().'.pdf';
			while (!file_exists ($file))
				$this->Output($file, 'f');
			return $file;
		}
		
		function Save($filename = "Brief.pdf") {
			$this->Output($filename, 'D');
		}
		function Show($filename = "Brief.pdf") {
			$this->Output($filename, 'I');
		}
		
		
	}
?>