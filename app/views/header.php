<!DOCTYPE html/>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title><?=$meta['title']?> | Omnibus #hackjsy 2014</title>
	
	<meta name="description" content="<?=$meta['description']?>"/>
	<meta name="keywords" content="<?=$meta['keywords']?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"type="text/javascript"></script> -->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600' rel='stylesheet' type='text/css'>

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
				<a href="index.php" class="home-header-icon"><img src="app/views/img/home.png" alt="logo" height="20"></a>
                <img src="app/views/img/omnibus-logo.png" alt="logo" height="25">
                <a href="info.php" class="info-header-icon"><img src="app/views/img/info.png" alt="logo" height="20"></a>
            </div>	
				<h1> <?=$heading?></h1>
		
	<!-- END OF HEADER SECTION -->
	
<?
unset($meta);
unset($heading);
