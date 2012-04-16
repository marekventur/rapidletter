<?php /* Der HTML-Header aller HTML-Dateien */?>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8" />
	
	<?php if (isset($seotitle)) {?>
	<title><?php echo $title; ?></title>
	<?php } else { ?>
	<title>RapidLetter - Der Online-Brief-Generator - <?php echo $title; ?></title>
	<?php } ?>
	
	<?php if (isset($meta_description)) {?>
	<meta name="description" content="<?=$meta_description?>">
	<?php } else { ?>
	<meta name="description" content="Erzeugen sie Briefe bequem, schnell und kostenlos direkt in ihrem Browser. Für professionelle Geschäftsbriefe nach DIN und für private Schreiben.">
	<?php } ?> 
	
	<?php 
	/*
		<link href="http://fonts.googleapis.com/css?family=Molengo" 	rel="stylesheet" type="text/css" media="screen" /> 
		<link href="http://fonts.googleapis.com/css?family=Cantarell" 	rel="stylesheet" type="text/css" media="screen" /> 
	*/
	?>
	<link href="http://fonts.googleapis.com/css?family=Nobile:regular,bold" rel="stylesheet" type="text/css">
	
	<link href="/css/<?=$template;?>.min.php" 						rel="stylesheet" type="text/css" media="screen" /> 
	<link href="/css/print.css" 									rel="stylesheet" type="text/css" media="print" /> 
	<!--[if IE]><link rel="stylesheet" type="text/css" media="screen" href="css/ie.css"/><![endif]-->
	<!--[if lte IE 6]><link rel="stylesheet" type="text/css" media="screen" href="css/ie6.css"/><![endif]-->
	<?php echo $header; ?>
	
</head>
