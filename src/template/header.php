<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="<?php echo filter_var($metaDescription, FILTER_SANITIZE_STRING); ?>" />
		<meta name="author" content="<?php echo filter_var($metaAuthor, FILTER_SANITIZE_STRING) ?>" />
		<title><?php echo filter_var($metaTitle, FILTER_SANITIZE_STRING); ?></title>
		<!-- Icon -->
		<link rel="shortcut icon" href="<?php echo URL . '/img/favicon.ico'; ?>" type="image/x-icon" />
		<link rel="apple-touch-icon" href="<?php echo URL . '/img/apple-touch-icon.png'; ?>" />
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL . '/img/apple-touch-icon-57x57.png'; ?>" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL . '/img/apple-touch-icon-72x72.png'; ?>" />
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL . '/img/apple-touch-icon-76x76.png'; ?>" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL . '/img/apple-touch-icon-114x114.png'; ?>" />
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL . '/img/apple-touch-icon-120x120.png'; ?>" />
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL . '/img/apple-touch-icon-144x144.png'; ?>" />
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL . '/img/apple-touch-icon-152x152.png'; ?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL . '/img/apple-touch-icon-180x180.png'; ?>" />
		<!-- FontAwesome CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
		<!-- Bootstrap Core CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
		<!-- Font -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
		<!-- Custom styles -->
		<link href="<?php echo URL . '/css/style.min.css'; ?>" rel="stylesheet" />
		<!-- Layout CSS -->
	</head>
	<body>
		<!-- Navbar -->
		<nav class="navbar navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo URL; ?>">
						<?php echo NAME; ?>
					</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-left">
						<?php foreach ($menuItems as $item) : ?>
							<li>
								<a class="<?php echo $item['class']; ?>" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>" style="<?php echo $item['style']; ?>"><?php echo $item['name']; ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="https://www.linkedin.com/in/cl%C3%A9ment-cazaud-685307142/" target="_blank" title="Follow me on LinkedIn"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="https://github.com/opportus/" target="_blank" title="Follow me on GitHub"><i class="fa fa-github" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="https://stackexchange.com/users/6322768" target="_blank" title="Follow me on StackExchange"><i class="fa fa-stack-overflow" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>
