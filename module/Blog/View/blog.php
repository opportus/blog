<?php require_once('header.php'); ?>
<!-- +++++ Posts Lists +++++ -->
<div class="section grey py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<section>
					<!-- Blog Heading -->
					<header>
					<!-- <img src="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/oc/blog/img/blog.png'); ?>" style="float:left; margin-right:40px;" /> -->
						<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
						<p><?php echo $toolbox->sanitizeString($description); ?></p>
					</header>
				</section>
			</div>
		</div>
	</div>
</div>
<?php foreach ($posts as $post): ?>
	<div class="white py section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<article>
						<!-- Post Image -->
						<!-- <p><img src="assets/img/user.png" width="50px" height="50px"> <ba>Stanley Stinson</ba></p> -->
						<!-- Post Date/Time -->
						<p><i class="fa fa-clock-o" aria-hidden="true"></i><bd><?php echo $toolbox->sanitizeString($post['datetime']); ?></bd></p>
						<!-- Post Header -->
						<header>
							<!-- Post Title -->
							<h2><?php echo $toolbox->sanitizeString($post['title']); ?></h2>
						</header>
<hr>
						<!-- Post Excerpt -->
						<p><?php echo $toolbox->sanitizeString($post['excerpt']); ?></p>
						<!-- Post Link -->
						<p><a href="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/post/' . $post['id']); ?>">Continue Reading...</a></p>
					</article>
				</div>
			</div><!-- /.row -->
		</div> <!-- /.container -->
	</div><!-- /.section -->
<?php endforeach; ?>
<?php require_once('footer.php'); ?>
