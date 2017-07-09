<?php

/**
 * The post view...
 *
 * @version 0.0.1
 * @package App\View
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
<?php require_once('part/header.php'); ?>
<!-- Post Content -->
<div>
	<!-- Edit Button -->
	<div><a class="btn btn-default" href="<?php echo $toolbox->sanitizeUrl($config->getApp('url') . '/cockpit/post-edit/' . $id); ?>">Edit post</a></div>
	<!-- Title -->
	<header class="page-header">
		<h1><?php echo $toolbox->escHtml($title); ?></h1>
	</header>
	<div>
		<!-- Date/Time -->
		<span><span class="glyphicon glyphicon-time"></span><?php echo $toolbox->escHtml($datetime); ?> by</span>
		<!-- Author -->
		<span class="lead">
			<?php echo $toolbox->escHtml($author); ?>
		</span>
	</div>
	<hr>
	<!-- Image -->
	<img class="img-responsive" src="<?php echo $toolbox->escHtml($imageUrl)?>" alt="<?php echo $toolbox->escHtml($imageAlt); ?>">
	<!-- Excerpt -->
	<p><?php echo $toolbox->escHtml($excerpt); ?></p>
	<!-- Content -->
	<p><?php echo $toolbox->escHtml($content); ?></p>
</div>
<?php require_once('part/footer.php'); ?>
