<?php
	$uid = '';
	if (isset($_GET['id']))
	$uid = $_GET['id'];
	
	$sql = "SELECT * FROM briefe WHERE uid='".$uid."' and ispublic=1 LIMIT 1;";
	
	$res = mysql_query($sql) or die(mysql_error());
	if(!$row = mysql_fetch_array($res)){
		die ('Link konnte leider nicht gefunden werden.');
	}
	
	$seotitle = true;
	$title = "Brief-Vorlage: ".urldecode($row['titel'])." - via Rapidletter.de";
	
	/* Validation Fehler durch das Fehlen einenes standartisierten Weges, 
	 * Facebooks "Open Graph Protocol" valide in HTML5 einzubinden */
	$header = '<meta property="og:title" content="Brief-Vorlage: '.$row['titel'].'"/>
	    <meta property="og:type" content="article"/>
	    <meta property="og:url" content="'.createURL("brief", "id=".$uid).'"/>
	    <meta property="og:image" content="http://www.rapidletter.de/img/letter/'.$uid.'.png"/>';
	
	$meta_description = urldecode($row['beschreibung']);
	
	$url_link = urlencode(createURL("brief", "id=".$uid));
	$url_title = urlencode('Brief-Vorlage: '.$row['titel']);
	$url_desc = urlencode('Brief-Vorlage: '.$row['beschreibung']);
	
	/* Bild vorhanden? */
	static_exists('img/letter/'.$uid.'.png');

?>
<h1>Brief-Vorlage: <?=$row['titel']?></h1>

<div class="designer_left"><img class="letter_preview_297"
	id="letter_preview" src="img/letter/<?=$uid?>.png" alt="Briefvorschau" />
</div>

<div class="designer_right">
	<h2>Benutzen sie diese Vorlage</h2>
	
	
	<div class="icon_with_text">
	<div class="icon icon_letter"></div>
	<?=html_entities($row['titel'])?>
	<div class="gray"><?=nl2br(html_entities($row['beschreibung']))?></div>
	</div>
	
	
	<span onclick="link_toogle()" class="orange_button"
		id="link_toggle_button">Den Betreff und Text anzeigen</span>
	
	
	<div class="link_preview" id="link_toggle_content"
		style="display: none;"><strong><?=html_entities($row['betreff'])?></strong>
	<?=nl2br(html_entities($row['text']))?></div>
	
	
	<a href="<?=createURL("loadletter", "id=".$row['id'])?>"
		class="orange_button">Einen Brief aus dieser Vorlage erzeugen &raquo;</a>
	
	<div class="hspace20"></div>
	<div class="hspace20"></div>
	<h2>Teile diese Vorlage mit anderen:</h2>
	<div id="social_bookmarks">
		<a href="http://twitter.com/home?status=<?=$url_title?>%20<?=$url_link?>" title="Twittern" target="_blank">
			<img class="sb_img" src="/img/social/social_twitter.png" alt="Twittern" height="48" width="48" />
		</a>
		<a href="http://de.facebook.com/sharer.php?u=<?=$url_link?>&amp;t=<?=$url_title?>" title="Mit Facebook-Freunden teilen" target="_blank">
			<img class="sb_img" src="/img/social/social_facebook.png" alt="Mit Facebook-Freunden teilen" height="48" width="48" />
		</a>
		<a href="http://www.mister-wong.de/index.php?action=addurl&amp;bm_url=<?=$url_link?>&amp;bm_description=<?=$url_title?>" title="Bei Mr. Wong eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_mrwong.png" alt="Bei Mr. Wong eintragen" height="48" width="48" />
		</a>
		<a href="http://delicious.com/save?url=<?=$url_link?>&amp;title=<?=$url_title?>&amp;tags=Musterbrief%2C%20Generator%2C%20Brief&amp;notes=<?=$url_desc?>" title="Bei delicious.com eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_delicious.png" alt="Bei delicious.com eintragen" height="48" width="48" />
		</a>
		<a href="http://www.stumbleupon.com/submit?url=<?=$url_link?>&amp;title=<?=$url_title?>" title="Bei Stumbleupon eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_stumble_upon.png" alt="Bei Stumbleupon eintragen" height="48" width="48" />
		</a>
		<a href="http://www.google.com/bookmarks/mark?op=add&amp;bkmk=<?=$url_link?>&amp;title=<?=$url_title?>&amp;labels=Musterbrief%2C%20Generator%2C%20Brief&amp;annotation=<?=$url_desc?>" title="Bei Google Bookmarks eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_google.png" alt="Bei Google Bookmarks eintragen" height="48" width="48" />
		</a>
		<a href="https://favorites.live.com/quickadd.aspx?marklet=1&amp;mkt=de-de&amp;url=<?=$url_link?>&amp;title=<?=$url_title?>&amp;top=1" title="Bei Windows Live eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_live.png" alt="Bei Windows Live eintragen" height="48" width="48" />
		</a>
		<a href="http://www.studivz.net/Link/Selection/Url/?u=<?=$url_link?>&amp;desc=<?=$url_title?>&amp;prov=rapidletter.de" title="Bei StudiVZ eintragen" target="_blank">
			<img class="sb_img" src="/img/social/social_studivz.png" alt="Bei StudiVZ eintragen" height="48" width="48" />
		</a>
		
		
	</div>
	<div class="hspace20"></div>
	
	<p><iframe
		src="http://www.facebook.com/widgets/like.php?href=<?=createURL("brief", "id=".$uid)?>" 
		<?php /*scolling="no" frameborder="0"*/ ?>
		style="border: none; width: 450px; height: 80px"></iframe></p>
</div>

<div class="designer_clear"></div>