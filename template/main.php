<?php 
	header("Content-type: text/html; charset=utf-8"); 
	include("head.php");
?>


<body>
	

	<div id="wrapper">
		<div id="header">
			<a href="<?php echo createURL(); ?>" id="logo"></a>
			<?php if ($user_is_logged_in) { ?>
			<a href="logout" id="login">Logout</a>
			<?php } else { ?>
			<a href="login" class="iframe" id="login">Login</a>
			<?php } ?>
			<ul id="logo_text">
				<li>In 5 Schritten einen professionellen Brief erzeugen</li>
				<li>Kostenlos speichern oder ausdrucken</li>
				<li>Nach DIN oder als Privatbrief</li>
			</ul>
			
			<ul id="navigation">
				
				<li><a href="<?php echo createURL("faq"); ?>">FAQ</a></li>
				<li><a href="<?php echo createURL("impressum"); ?>">Impressum</a></li>
				<li><a href="<?php echo createURL("musterbrief"); ?>">Musterbriefe</a></li>
				<?php if ($user_is_logged_in) { ?>
				<li><a href="<?php echo createURL("profil"); ?>">Ihr Profil</a></li>
				<?php } ?>
				<li><a href="<?php echo createURL("index"); ?>">Startseite</a></li>
			</ul> 
		</div>
		<div id="content">
			<?php echo $content; ?>
		</div>
		<div id="footer">
			Copyright 2010 by Gabriele Matthies, Rudolf Penner, <a href="http://marekventur.com/" title="Marek Ventur">Marek Ventur</a> | 
			<a href="<?php echo createURL("kontakt"); ?>">Kontakt</a>
		</div>
	</div>
	
	
	
<?php include("foot.php"); ?>
