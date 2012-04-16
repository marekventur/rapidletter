/* Diese Javscript wird von "Vorlagen" und "Textbausteine" verwendet */

$(document).ready(function() {
	/* Non-Javascript-Warnungen ausblenden */
	$('.w_javascript').css('display', 'block');
	$('.wo_javascript').css('display', 'none');
	
	/* Einzelne Vorlagen ausblenden */
	$('.text_part').css('display', 'none');
	
	/* Bei klick auf Titel entsrechende Vorlage anzeigen */
	$('.link_to_show_div').click(function() {
		$('#choose_info, .text_part').css('display', 'none');
		$($(this).attr('href')).css('display', 'block');
		return false;
	});		
	
	/* Vorlage verwenden */
	$('.use_template').click(function() {
		if ( $.browser.msie ) {
  			text = $($(this).attr('href')+' .text').html().replace(/<BR>/g,"\n");
		}
		else
		{
			text = $($(this).attr('href')+' .text').text();
		}
		
		parent.use_template(
			$($(this).attr('href')+' .betreff').text(),
			text
		);
		return false;
	})

	/* inkrementelle Suchfunktion bei Textblöcken */
	$('#search_text').keyup(function() {
		$('.textblock').map(function() {
        	var el = $(this);
			//alert(el.text().toLowerCase().indexOf($('#search_text').val().toLowerCase()));
       		if (el.text().toLowerCase().indexOf($('#search_text').val().toLowerCase())>-1) {
				el.css("display", "block");
			}
			else
			{
				el.css("display", "none");
			}
    	});
	});
	
	/* Textlock einfügen */
	$('.use_textblock').click(function() {
		if ( $.browser.msie ) {
  			text = $($(this).attr('href')+' .text').html().replace(/<BR>/g,"\n");
		}
		else
		{
			text = $($(this).attr('href')+' .text').text();
		}
		parent.use_textblock(text);
		return false;
	})

});
