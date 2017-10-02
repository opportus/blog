<?php

/**
 * The blog view...
 *
 * @version 0.0.1
 * @package CMS\View
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
<?php require_once('part/header.php'); ?>
<!-- Blog Page -->
<div>
	<!-- Blog Heading -->
	<header class="jumbotron">
		<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
		<p><?php echo $toolbox->sanitizeString($description); ?></p>
	</header>
	<!-- Posts -->
	<?php foreach ($posts as $post): ?>
		<article>
			<a href="<?php echo $toolbox->sanitizeUrl($config->getApp('url') . '/post/' . $post['id']); ?>" style="color:inherit;text-decoration:none;">
				<!-- Title -->
				<h2><?php echo $toolbox->sanitizeString($post['title']); ?></h2>
				<!-- Date/Time -->
				<p><span class="glyphicon glyphicon-time"></span><?php echo $toolbox->sanitizeString($post['datetime']); ?></p>
				<hr>
				<!-- Image -->
				<?php if ($post['imageUrl']) : ?>
					<img class="img-responsive" src="<?php echo $toolbox->sanitizeUrl($post['imageUrl']); ?>" alt="<?php echo $toolbox->sanitizeString($post['imageAlt']); ?>" title="<?php echo $toolbox->sanitizeString($post['imageTitle']); ?>">
					<hr>
				<?php endif; ?>
				<!-- Post Excerpt -->
				<p><?php echo $toolbox->sanitizeString($post['excerpt']); ?></p>
				<hr>
			</a>
		</article>
	<?php endforeach; ?>
</div>
<?php require_once('part/footer.php'); ?>
