<?php 
	/* Diese Seite listet alle freigegebenen Musterbriefe auf und zeigt alle Vorlagen an */
	$title = "Musterbriefe";
?>

<h1>Musterbriefe</h1>

<?php 
	
	$sql = "SELECT * FROM briefe WHERE ispublic=1 and showpublic=1 LIMIT 10;";
	
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($res)){
		echo '<div class="icon_with_text rounded_grey_border">
		<div class="icon icon_letter"></div><a href="'.createURL("brief", "id=".$row['uid']).'">'.
		html_entities($row['titel']).
		'</a><div class="gray">'.nl2br(html_entities($row['beschreibung'])).'</div>
		
		<div class="clear_both"></div>
		
		<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode(createURL("brief", "id=".$row['uid'])).'&amp;layout=button_count&amp;show_faces=true&amp;width=120&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="float:right; border:none; overflow:hidden; width:120px; height:21px;" allowTransparency="true"></iframe>
		
		<div class="clear_both"></div>
		
		</div>';
	}
	
	$sql = "SELECT betreff, text, id, titel FROM vorlagen;";
	$res = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($res)){
		echo '<div class="icon_with_text rounded_grey_border">
		<div class="icon icon_letter"></div><a href="'.createURL("newletter", "vorlage=".$row['id']).'">'.
		html_entities($row['titel']).
		'</a><div class="gray">'.nl2br(html_entities($row['text'])).'</div>
		
		<div class="clear_both"></div>
		
		</div>';
	
	}
	

?>
