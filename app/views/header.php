<!DOCTYPE html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title><?=$meta['title']?> | Omnibus #hackjsy 2014</title>

	<meta name="description" content="<?=$meta['description']?>"/>
	<meta name="keywords" content="<?=$meta['keywords']?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="app/views/css/normalize.css">
	<link rel="stylesheet" href="app/views/css/main.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-55272326-1', 'auto');
	  ga('send', 'pageview');
	</script>
</head>
<body>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<!-- Add your site or application content here -->
	<div id="container">

	<!-- HEADER SECTION -->
		<div id="headertop">
				<a href="index.php" class="home-header-icon"><i class="fa fa-home fa-2x"></i></a>
                <div class="logo"><img src="app/views/img/liberty_logo.png" alt="Liberty Bus App"/></div>
                <a href="info.php" class="info-header-icon"><i class="fa fa-cog fa-2x"></i></a>
            </div>
				<h1> <?=$heading?></h1>

	<!-- END OF HEADER SECTION -->

<?
unset($meta);
unset($heading);
