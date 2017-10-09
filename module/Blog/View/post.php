<?php require_once('header.php'); ?>
<!-- +++++ Post +++++ -->
<div class="section white py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<!-- Edit Button -->
				<a class="btn btn-default mb" href="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/cockpit/post/edit/' . $id); ?>">Edit Post</a>
				<div>
					<!-- Post Date/Time -->
					<i class="fa fa-clock-o"></i><bd><?php echo $toolbox->sanitizeString($datetime); ?></bd>
					<!-- Post Author -->
					<span class="lead my"><!-- <img src="<?php //echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/img/icon/apple-touch-icon-57x57.png'); ?>" /> --><ba><?php echo 'by ' . $toolbox->sanitizeString($author); ?></ba>
				</div>
				<header>
					<!-- Post Title -->
					<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
				</header>
				<!-- Post Image -->
				<!-- <p><img class="img-responsive" src="assets/img/blog01.jpg" alt=""></p> -->
				<hr>
				<!-- Post Excerpt -->
				<p><?php echo $toolbox->sanitizeString($excerpt); ?></p>
				<!-- Post Content -->
				<p><?php echo $toolbox->escHtml($content); ?></p>
				<br>
				<!-- Post Tags -->
				<!-- <p><bt>TAGS: <a href="#">Wordpress</a> - <a href="#">Web Design</a></bt></p> -->
				<hr>
				<!-- Back Link -->
				<p><a href="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/blog/'); ?>"># Back</a></p>
			</div>
		</div><!-- /.row -->
	</div> <!-- /.container -->
</div><!-- /.section -->
<?php require_once('footer.php'); ?>
