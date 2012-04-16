<?php 
	/* Diese Seite erlaubt es dem Benutzer eine fertige Vorlage zu verwenden */
	$title = "Vorlagen";
	$script = "";
	$template = "plain";
	$footer = '<script src="/js/vorlage_textbausteine.js" charset="utf-8" type="text/javascript"></script>';
	
	$links = "";
	$text = "";
	$last_kategorie = "";
	
	$sql="SELECT * FROM  vorlagen ORDER BY kategorie";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($res)){
		if($row['kategorie'] != $last_kategorie) {
			$last_kategorie = $row['kategorie'];
			if($links == '')
				$links .= "<li><strong>".$row['kategorie']."</strong><ul>";
			else	
				$links .= "</ul></li><li><strong>".$row['kategorie']."</strong><ul>";
		}	
		$links .= '<li><a href="#link_'.$row['id'].'" class="link_to_show_div">'.html_entities($row['titel']).'</a></li>';
		
		$text .=  '<div class="text_part" id="link_'.$row['id'].'">
		<h3>'.$row['titel'].'</h3>
		<div class="wo_javascript info_box">In ihrem Browser scheint JavaScript deaktiviert zu sein - wir können sie daher nicht mit einigen Hilfsfunktionen unterstützen. Wenn sie diesen Text als Vorlage verwenden wollen, müssen sie den Text makieren, in die Zwischenablage kopieren und in dem Eingabefeld wieder einfügen.</div>
		<a style="display: none;" href="#link_'.$row['id'].'" class="use_template w_javascript icon_button icon_button_template"><div class="icon_button_spacer"></div>Den aktuellen Brief mit dieser Vorlage überschreiben</a>
		<div class="clear_left"></div>
		<div class="betreff">'.html_entities($row['betreff']).'</div>
		<div class="text">'.nl2br(html_entities($row['text'])).'</div></div>';
		
		
	} 
	$links .= "</ul></li>";
	
?>
<div id="header">
	<h1>Brieftext</h1>
	<h2>Wählen Sie eine Vorlage </h2>
</div>

<div id="left">
	<ul>
		<?php echo $links; ?>
	</ul>
</div>

<div id="right">
	<div id="choose_info" class="info_box info_box_margin_top w_javascript" style="display: none;">
		Bitte wählen Sie links eine passende Vorlage aus.
	</div>
	<?php echo $text; ?>
</div>
