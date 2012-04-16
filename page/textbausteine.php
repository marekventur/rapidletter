<?php 
	/* Auf dieser IFrame-Seite kann der Benutzer Textbausteine auswählen und einfügen */
	$title = "Textbausteine";
	$script = "";
	$template = "plain";
	$footer = '<script src="/js/vorlage_textbausteine.js" charset="utf-8" type="text/javascript"></script>';
	
	
?>
<div id="header">
	<h1>Textbausteine</h1>
	<h2>Suchen Sie nach passenden Textbausteinen</h2>
</div>

<div class="wo_javascript info_box info_box_margin_top">
	In Ihrem Browser scheint JavaScript deaktiviert zu sein - wir können Sie daher nicht mit einigen 
	Hilfsfunktionen unterstützen. Wenn Sie diesen Text als Vorlage verwenden wollen, müssen Sie den Text 
	makieren, in die Zwischenablage kopieren und in dem Eingabefeld wieder einfügen.<br />
	Die meisten Browser bieten Suchmöglichkeiten an, mit denen Sie diese Seite nach passenden 
	Textbausteinen durchsuchen können.
</div>

<div class="w_javascript info_box info_box_margin_top" style="display:none;">
	<label for="search_text">Suchbegriff:</label> <input type="text" value="" id="search_text" id="search_text" />
</div>

<?php 
	$sql="SELECT * FROM  textbausteine";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($res)){
		echo '<div class="textblock" id="link_'.$row['id'].'">
	<a style="display: none;" href="#link_'.$row['id'].'" class="use_textblock w_javascript icon_button icon_button_textblock">
		<div class="icon_button_spacer"></div>Einfügen</a>
	<div class="text">'.nl2br(html_entities($row['text'])).'</div>
	<div class="keywords">'.html_entities($row['schlagwoerter']).'</div>	
</div>';
			
	} 
?>
