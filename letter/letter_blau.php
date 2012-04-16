<?php 
	require('genericLetter.php');
	
	class Letter extends GenericLetter
	{
		/* Die Funktion ermöglicht gedrehten Text mit FPDF */ 
		function Rotate($angle,$x=-1,$y=-1) { 
			if($x==-1) 
            	$x=$this->x; 
	       	if($y==-1) 
	            $y=$this->y; 
	        if($this->angle!=0) 
	            $this->_out('Q'); 
	        $this->angle=$angle; 
	        if($angle!=0) 
	
	        { 
	            $angle*=M_PI/180; 
	            $c=cos($angle); 
	            $s=sin($angle); 
	            $cx=$x*$this->k; 
	            $cy=($this->h-$y)*$this->k; 
	             
	            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy)); 
	        } 
	    } 
	
		// Schrift
		public $font = "Arial";
		
		/* Den blauen Balken auf jeder Seite anzeigen */
		function Header() {
			parent::Header();
			@$this->Image(PATH."letter/letter_blue_bg.png",0,0,20,297);	
			$this->SetXY(16, 30);
			$this->Rotate(-90);
			$this->SetFont($this->font,'b',18);
			$this->SetTextColor(255);
			$text = explode(',', $this->absender);
			$this->Write(20,utf8_decode($text[0]));
			$this->Rotate(0);  	
		}
		
	}

?>