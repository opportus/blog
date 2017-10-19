<?php $metaTitle       = 'My Tech Blog'; ?>
<?php $metaDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam pellentesque sem id molestie. Pellentesque nec lectus a sapien posuere sollicitudin. Vivamus nec tortor turpis.'; ?>
<?php $metaAuthor      = 'Clément Cazaud'; ?>
<?php require_once('header.php'); ?>
<!-- +++++ Posts Lists +++++ -->
<div class="section grey py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<section>
					<!-- Blog Heading -->
					<header>
						<h1><?php echo $metaTitle; ?></h1>
						<p><?php echo $metaDescription; ?></p>
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
						<p><i class="fa fa-clock-o" aria-hidden="true"></i><bd><?php echo date(APP_DATE_FORMAT . ' ' . APP_TIME_FORMAT, strtotime($post['datetime'])); ?></bd></p>
						<!-- Post Header -->
						<header>
							<!-- Post Title -->
							<h2><?php echo filter_var($post['title'], FILTER_SANITIZE_STRING); ?></h2>
						</header>
<hr>
						<!-- Post Excerpt -->
						<p><?php echo filter_var($post['excerpt'], FILTER_SANITIZE_STRING); ?></p>
						<!-- Post Link -->
						<p><a href="<?php echo APP_URL . '/post/' . $post['id']; ?>">Continue Reading...</a></p>
					</article>
				</div>
			</div><!-- /.row -->
		</div> <!-- /.container -->
	</div><!-- /.section -->
<?php endforeach; ?>
<!-- JS Scripts
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php require_once('footer.php'); ?>
