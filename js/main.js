/* Eventhandler für "DOM-Baum fertig aufgebaut" */
$(document).ready(function() { 

	/* Inititiere Colorbox für alle Links mit der Klasse "iframe" */
	$('#wrapper .iframe').colorbox({
		width: '800px',
		height: '600px',
		iframe: true, 
		opacity:0.4
	});
	
	/* Links innerhalb eines IFrame müssen nicht mehr in einem neuen Fenster geöffnet werden */
	$('#template_plain .iframe').attr('target', '_self');
	 
	/* Die Enter-Taste zum Navigieren in Designer 2-4 verwendbar machen */
	/* Alle Input Felder selektieren */
	var form_inputs = $('.designer_form input[type=text]');

	/* Das Keydown-Event überwachen */
	$(form_inputs).keydown(function(event) {
		/* Enter = Keycode 13 */
	 	if (event.keyCode == 13) {
			/* Index des nächsten Feldes */
  			var i = form_inputs.index(this) + 1;
			/* Ausgeblendete Felder überspringen */
			while((form_inputs[i] != null) && ($(form_inputs[i]).is(':hidden'))) i++;
			/* Kontrollieren, ob es existiert */
			if (form_inputs[i] != null) 
				/* Focus setzten */
				$(form_inputs[i]).focus().select();
			else
			{
				/* Wenn nicht im Designer 4, dann... */
				if ($('.designer_form:first').attr('action').indexOf('designer4')==-1) 
					/* ...simuliere Klick auf "do_next"-Button */
					$('.designer_form:first').append($('<input type="hidden" name="do_next" value="dummy" />')).submit();
				else
					/* ..sonst setzte Fokus auf das Textfeld */
					$('#text').focus().select();	
			}
			/* Standart-Verhalten unterdrücken */
			return false;
 		}  
	});	
	
	/* Focus auf das erste Eingabefeld legen */
	if (form_inputs[0] != null) form_inputs[0].focus();

});

/* Initialisiere Designer 1 */
function init_designer1() {
	$(document).ready(function() {
		/* Bei Klick auf Thumbnails die Klassen aktialiseren, hidden-input aktualisieren und refreshen */
		$('.letter_preview_150').click(function() {
			$('.letter_preview_150').removeClass('letter_preview_150_active');
			$(this).addClass('letter_preview_150_active');
			$('#design').val($(this).attr('id').substr(7));
			refresh_preview(1);
			return false;
		});
		
		/* Mouseover-Effekte für die Thumbnails erstellen */
		$('.letter_preview_150_noactive').removeClass('use_hover').hover(function() {
			$('.letter_preview_hover', this).clearQueue().animate({
			    'height': 48,
			    'top': 155
			  }, 150);
		}).mouseout(function() {
			$('.letter_preview_hover', this).clearQueue().animate({
			    'height': 0,
			    'top': 203
			  }, 150);
		}).each(function() {
			$('.letter_preview_hover', this).css({
			    'height': 0,
			    'top': 203
			  }).css('visibility', 'visible');
		});
		
		/* Sollte ein Refresh-Button vorhanden sein, diesen mit refresh_preview verknüpfen */
		$('.refresh_button').click(function(){return refresh_preview(1);});
		
	});
}

/* Ersetze Text und Betreff durch fertige Vorlagen (Kann von den IFrames aus aufgerufen werden) */
function use_template(betreff, text) {
	$('#betreff').val(betreff);
	$('#text').val(text);
	$.fn.colorbox.close();
}

/* Füge einen Textblock an den bereits bestehenden Text an (Kann von den IFrames aus aufgerufen werden) */
function use_textblock(text) {
	$('#text').val($('#text').val()+"\n\n"+text);
	$.fn.colorbox.close();
}

/* Die IFrame-Colorbox-schließen (Kann von den IFrames aus aufgerufen werden) */
function close_colorbox() {
	$.fn.colorbox.close();
}

/* Diese Funktion läd die Seite neu (Kann von den IFrames aus aufgerufen werden) */ 
function refresh_parent() {
	$.fn.colorbox.close();
}

/* Designer-Schritt 3: Den Wechsellink mit den passenden Event-Handlern verbinden */
function designer3_swap(normal) {
	if (normal) 
		$('#designer3_swap').click(designer3_full);
	else 
		$('#designer3_swap').click(designer3_normal);	
}

/* Designer-Schritt 3: Zum Textarea-Eingabefeld wecheseln  */
function designer3_full() {
	/* Mit Inhalt füllen */
	if ($('#empfaenger_full').val() == '') {
		var content = $('#empfaenger_firmenname').val(); 
		if (content != '') content += "\n";
		if ($('#empfaenger_anrede').val() != '') content += $('#empfaenger_anrede').val()+' ';
		if ($('#empfaenger_vorname').val() != '') content += $('#empfaenger_vorname').val()+' ';
		if ($('#empfaenger_nachname').val() != '') content += $('#empfaenger_nachname').val();
		content += "\n"+$('#empfaenger_strasse').val()+" "+$('#empfaenger_hausnummer').val();
		content += "\n"+$('#empfaenger_plz').val()+" "+$('#empfaenger_ort').val();	
		$('#empfaenger_full').val(content);
	}
	
	/* Alte Box ausblenden danach neue einblenden */
	$('#designer3_normal').hide(300, function() {
		$('#designer3_full').show(300);
	})
	
	/* Link ausblenden, Text wechseln, wieder einblenden, Event-Handler wechseln */
	$('#designer3_swap').animate({opacity: 0.1}, 300, function() {
    	$('#designer3_swap').text('Auf normale Adressfeld-Eingabe umschalten').animate({opacity: 1}, 300);
  	}).unbind().click(designer3_normal);
	
	/* Hidden-Input-Feld aktualisieren */
	$('#empfaenger_show_normal').val('0');
	
	/* Vorschau aktualisieren */
	refresh_preview(3);
	
	/* Dem Link nicht weiter folgen */
	return false;
}

/* Designer-Schritt 3: Zur normalen Eingabeart wecheseln  */
function designer3_normal() {
	/* Alte Box ausblenden danach neue einblenden */
	$('#designer3_full').hide(300, function() {
		$('#designer3_normal').show(300);
	})
	
	/* Link ausblenden, Text wechseln, wieder einblenden, Event-Handler wechseln */
	$('#designer3_swap').animate({opacity: 0.1}, 300, function() {
    	$('#designer3_swap').text('Auf direkte Adressfeld-Eingabe umschalten').animate({opacity: 1}, 300);
  	}).unbind().click(designer3_full);
	
	/* Hidden-Input-Feld aktualisieren */
	$('#empfaenger_show_normal').val('1');
	
	/* Vorschau aktualisieren */
	refresh_preview(3);
	
	/* Dem Link nicht weiter folgen */
	return false;
}

/* Adressbucheintrag: Den Wechsellink mit den passenden Event-Handlern verbinden */
function adressbucheintrag_swap(normal) {
	if (normal) 
		$('#adressbucheintrag_swap').click(adressbucheintrag_full);
	else 
		$('#adressbucheintrag_swap').click(adressbucheintrag_normal);	
}

/* Adressbucheintrag: Zum Textarea-Eingabefeld wecheseln  */
function adressbucheintrag_full() {
	/* Mit Inhalt füllen */
	if ($('#full').val() == '') {
		var content = $('#firmenname').val(); 
		if (content != '') content += "\n";
		if ($('#anrede').val() != '') content += $('#anrede').val()+' ';
		if ($('#vorname').val() != '') content += $('#vorname').val()+' ';
		if ($('#nachname').val() != '') content += $('#nachname').val();
		content += "\n"+$('#strasse').val()+" "+$('#hausnummer').val();
		content += "\n"+$('#plz').val()+" "+$('#ort').val();	
		$('#full').val(content);
	}
	
	/* Alte Box ausblenden danach neue einblenden */
	$('#adressbucheintrag_normal').hide(300, function() {
		$('#adressbucheintrag_full').show(300);
	})
	
	/* Link ausblenden, Text wechseln, wieder einblenden, Event-Handler wechseln */
	$('#adressbucheintrag_swap').animate({opacity: 0.1}, 300, function() {
    	$('#adressbucheintrag_swap').text('Auf normale Adressfeld-Eingabe umschalten').animate({opacity: 1}, 300);
  	}).unbind().click(adressbucheintrag_normal);
	
	/* Hidden-Input-Feld aktualisieren */
	$('#show_normal').val('0');
	
	/* Dem Link nicht weiter folgen */
	return false;
}

/* Adressbucheintrag: Zur normalen Eingabeart wecheseln  */
function adressbucheintrag_normal() {
	/* Alte Box ausblenden danach neue einblenden */
	$('#adressbucheintrag_full').hide(300, function() {
		$('#adressbucheintrag_normal').show(300);
	})
	
	/* Link ausblenden, Text wechseln, wieder einblenden, Event-Handler wechseln */
	$('#adressbucheintrag_swap').animate({opacity: 0.1}, 300, function() {
    	$('#adressbucheintrag_swap').text('Auf direkte Adressfeld-Eingabe umschalten').animate({opacity: 1}, 300);
  	}).unbind().click(adressbucheintrag_full);
	
	/* Hidden-Input-Feld aktualisieren */
	$('#show_normal').val('1');
	
	/* Dem Link nicht weiter folgen */
	return false;
}

function refresh_preview(nr) {
	/* Brief ausblenden */
	$('#letter_preview').animate({opacity: 0.1}, 300);
	
	/* Wenn ein Upload in Designer 1 vorliegt den Submit ausführen */
	if (nr==1) {
		if ($('#letter_logo_upload').size() > 0) {
			if ($('#letter_logo_upload').val() != '') {
				return true;
			}
		}	
	}
	
	/* ...ansonsten das Formaular via Ajax übertragen */
	$.ajax({
	  type: 'POST',
	  url: 'ajax/refresh_designer.php?nr='+nr,
	  data: $('.designer_form').serialize(),
	  success: function(ret) {
	  	/* Bei Erfolg das Vorschaubild neu laden und im OnLoad-Teil wieder einblenden */
	  	$('#letter_preview').attr('src','/letter.png?r='+ret).unbind().load(function() {
			$('#letter_preview').animate({opacity: 1}, 300);
		});
		
	  }
	}); 
	return false;
}

/* Eingabefelder für die Beugszeichenzeile nur anzeigen, wenn die Option gewählt ist */
function show_bzz() {
	if ($('#bzz_use').val() == 'bzz') {
		$('#bzz_ihrzeichen, #bzz_unserzeichen, #bzz_name, #bzz_telefon, #bzz_datum').parent().show();
		$('#bzz_fax, #bzz_email, #bzz_internet').parent().hide();
	}
	if ($('#bzz_use').val() == 'no') {
		$('#bzz_ihrzeichen, #bzz_unserzeichen, #bzz_name, #bzz_telefon, #bzz_datum').parent().hide();
		$('#bzz_fax, #bzz_email, #bzz_internet').parent().hide();
	}
}

/* Eingabefelder für die Beugszeichenzeile im Profil nur anzeigen, wenn die Option gewählt ist */
function show_bzz_profil() {
	if ($('#use_bzz').val() == 'bzz') {
		$('#name, #telefon').parent().show();
		$('#fax, #email, #internet').parent().hide();
	}
	if ($('#use_bzz').val() == 'no') {
		$('#name, #telefon').parent().hide();
		$('#fax, #email, #internet').parent().hide();
	}
}

/* "Löschen"-Links mit einer Nachfrage ausstatten */
function init_delete_confirm(delete_text) {
	$('.delete_confirm, .delete_confirm_button').click(function() {
		$(this).unbind('click').text('Wirklich löschen?');
		window.setTimeout("init_delete_confirm('"+delete_text+"');", 5000);
		return false;
	}).text(delete_text);
}

/* "Löschen"-Buttons mit einer Nachfrage ausstatten */
function init_delete_confirm_button(delete_text) {
	$('.delete_confirm, .delete_confirm_button').click(function() {
		$(this).unbind('click').val('Wirklich löschen?');
		window.setTimeout("init_delete_confirm_button('"+delete_text+"');", 5000);
		return false;
	}).val(delete_text);
}

/* Button ausblenden, Inhalt einblenden */
function link_toogle() {
	$('#link_toggle_button').hide(500);
	$('#link_toggle_content').show(500);
}

