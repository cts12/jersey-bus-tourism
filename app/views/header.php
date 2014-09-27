<!DOCTYPE html/>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title><?=$meta['title']?> | Omnibus #hackjsy 2014</title>
	
	<meta name="description" content="<?=$meta['description']?>"/>
	<meta name="keywords" content="<?=$meta['keywords']?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<link rel="stylesheet" href="app/views/css/normalize.css">
	<link rel="stylesheet" href="app/views/css/main.css">
</head>
<body>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<!-- Add your site or application content here -->
	<div id="container">

	<!-- HEADER SECTION -->
		<div id="headertop">
                <a href="index.php"><img src="app/views/img/omnibus-logo.png" alt="logo" height="25"></a>
            </div>	
				<h1> <?=$heading?></h1>
		
	<!-- END OF HEADER SECTION -->
	
<?
unset($meta);
unset($heading);
