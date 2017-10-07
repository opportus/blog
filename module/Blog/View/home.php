<?php

/**
 * The homepage view...
 *
 * @version 0.0.1
 * @package OC\Blog\View
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
	<?php if ('' !== $failureNotif) : ?>
		<div class="alert alert-danger">
			<?php echo $toolbox->sanitizeString($failureNotif); ?>
		</div>
	<?php elseif ('' !== $successNotif) :?>
		<div class="alert alert-success">
			<?php echo $toolbox->sanitizeString($successNotif); ?>
		</div>
	<?php endif;?>
	<form method="post" action="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/contact/'); ?>">
		<div class="form-group row">
			<div class="col-md-6">
				<input id="email" name="email" class="form-control" type="email" placeholder="Your email..." value="<?php echo $toolbox->sanitizeString($email); ?>" required>
			</div>
  		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<input id="name" name="name" class="form-control" type="text" placeholder="Your name..." value="<?php echo $toolbox->sanitizeString($name); ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<textarea id="message" name="message" class="form-control" rows="12" placeholder="Your message..." required><?php echo $toolbox->sanitizeString($message); ?></textarea>
			</div>
		</div>
		<div>
			<input id="token" name="token" type="hidden" value="<?php echo $toolbox->sanitizeString($token); ?>">
			<button type="submit" class="btn btn-default">Send</button>
		</div>
	</form>
</div>
<?php require_once('part/footer.php'); ?>
