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
	<div><a class="btn btn-default" href="<?php echo $toolbox->sanitizeUrl($config->getApp('url') . '/cockpit/post/edit/' . $id); ?>">Edit post</a></div>
	<!-- Title -->
	<header class="page-header">
		<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
	</header>
	<div>
		<!-- Date/Time -->
		<span><span class="glyphicon glyphicon-time"></span><?php echo $toolbox->sanitizeString($datetime); ?> by</span>
		<!-- Author -->
		<span class="lead">
			<?php echo $toolbox->sanitizeString($author); ?>
		</span>
	</div>
	<hr>
	<!-- Image -->
	<?php if ($imageUrl) : ?>
		<img class="img-responsive" src="<?php echo $toolbox->sanitizeUrl($imageUrl)?>" alt="<?php echo $toolbox->sanitizeString($imageAlt); ?>">
	<?php endif; ?>
	<!-- Excerpt -->
	<p><?php echo $toolbox->sanitizeString($excerpt); ?></p>
	<!-- Content -->
	<p><?php echo $toolbox->sanitizeString($content); ?></p>
</div>
<?php require_once('part/footer.php'); ?>
