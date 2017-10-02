<?php

/**
 * The header template...
 *
 * @version 0.0.1
 * @package App\View\Part
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $toolbox->sanitizeString($description); ?>">
	<meta name="author" content="<?php echo $toolbox->sanitizeString($author) ?>">
	<title><?php echo $toolbox->sanitizeString($title); ?></title>
	<!-- FontAwesome CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- Bootstrap Core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
	<!-- Layout CSS -->
	<style>
		body{padding-top:70px;}
		footer{margin:50px 0;}
		*{font-family:'Open Sans', sans-serif;}
		h1,h2,h3,h4,h5,h6{font-family:'Raleway', sans-serif;}
		.nav a {font-size:13px;}
		@media (min-width: 768px) {
			.nav.right-hand {
				float: right;
		}
	</style>
</head>
<body>
	<header>
		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
 	   	<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $toolbox->sanitizeUrl($config->getApp('url')); ?>">
						<?php if (isset($logo)) : ?>
							<img class="navbar-brand" src="<?php echo $toolbox->sanitizeUrl($logo['url']); ?>" title="<?php echo $toolbox->sanitizeString($logo['title']); ?>" alt="<?php echo $toolbox->sanitizeString($logo['alt']); ?>" style="<?php echo $toolbox->sanitizeString($logo['style']); ?>">
						<?php else : ?>
							<?php echo $toolbox->sanitizeString($config->getApp('name')); ?>
						<?php endif;?>
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<?php foreach ($menuItems as $item) : ?>
							<li>
								<a class="<?php echo $toolbox->sanitizeString($item['class']); ?>" href="<?php echo $toolbox->sanitizeUrl($item['link']); ?>" title="<?php echo $toolbox->sanitizeString($item['title']); ?>" style="<?php echo $toolbox->sanitizeString($item['style']); ?>"><?php echo $toolbox->sanitizeString($item['name']); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<ul class="nav navbar-nav right-hand">
						<?php foreach ($menuItemsRightHand as $item) : ?>
							<li>
								<a class="<?php echo $toolbox->sanitizeString($item['class']); ?>" href="<?php echo $toolbox->sanitizeUrl($item['link']); ?>" title="<?php echo $toolbox->sanitizeString($item['title']); ?>" style="<?php echo $toolbox->sanitizeString($item['style']); ?>"><?php echo $toolbox->sanitizeString($item['name']); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>
		<!-- /.navbar -->
	</header>
	<!-- /.header -->
	<div class="container">
