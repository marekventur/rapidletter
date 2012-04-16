	
	<?php /* jQuery-Script vom Google-CDN */?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" 	charset="utf-8" type="text/javascript" ></script>
	<?php /* Das jQuery-Plugin Colorbox */?>
	<script src="/js/jquery.colorbox-min.js" 										charset="utf-8" type="text/javascript" ></script>
	<?php /* Die main.js mit den Javascript-Funktionen */?>
	<script src="/js/main.js" 													charset="utf-8" type="text/javascript" ></script>
	<?php /* Dieses Script bringt dem IE HTML5-Tags bei */?>
	<!--[if IE]><script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php 
		/* Soll in den Footer noch etwas eingefügt werden? */
		if ($footer!='') { echo $footer; }  
		
		/* Wurde ein inline-Script angegeben? */
		if ($script!='') { echo '<script type="text/javascript">'.$script.'</script>'; }  
		
		/* Im Main-Template Framing verhindern */
	 	if ($template == "main") { echo '<script type="text/javascript">if (top.location != self.location) top.location = self.location;</script>'; } 
	 ?>


	<?php /* Google Analytics Scripteinbindung */?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17216412-1']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>

</body>
</html>