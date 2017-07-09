<?php

/**
 * The homepage view...
 *
 * @version 0.0.1
 * @package App\View
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
<?php require_once('part/header.php'); ?>
<!-- Homepage Content -->
<div>
	<!-- Title -->
	<header class="jumbotron">
		<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
		<p><?php echo $toolbox->sanitizeString($description); ?></h1>
	</header>
	<hr>
	<!-- Contact Form -->
	<h2 id="contact">Contact</h2>
	<form method="post" action="<?php echo $toolbox->sanitizeUrl($config->getApp('url') . '/contact/'); ?>">
		<div class="form-group row">
			<div class="col-md-6">
				<input id="email" name="email" class="form-control" type="email" placeholder="Your email...">
			</div>
  		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<input id="name" name="name" class="form-control" type="text" placeholder="Your name...">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<textarea id="message" name="message" class="form-control" rows="12" placeholder="Your message..."></textarea>
			</div>
		</div>
		<div>
			<button type="submit" class="btn btn-default">Send</button>
		</div>
	</form>
</div>
<?php require_once('part/footer.php'); ?>
