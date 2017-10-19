<?php require_once('header.php'); ?>
<!-- +++++ Post +++++ -->
<div class="section white py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<!-- Edit Button -->
				<a class="btn btn-default mb" href="<?php echo APP_URL . '/cockpit/post/edit/' . $postId; ?>">Edit Post</a>
				<div>
					<!-- Post Date/Time -->
					<i class="fa fa-clock-o"></i><bd><?php echo date(APP_DATE_FORMAT . ' ' . APP_TIME_FORMAT, strtotime($postDatetime)); ?></bd>
					<!-- Post Author -->
					<span class="lead my"><ba><?php echo 'by ' . filter_var($postAuthor, FILTER_SANITIZE_STRING); ?></ba>
				</div>
				<header>
					<!-- Post Title -->
					<h1><?php echo filter_var($postTitle, FILTER_SANITIZE_STRING); ?></h1>
				</header>
				<!-- Post Image -->
				<!-- <p><img class="img-responsive" src="assets/img/blog01.jpg" alt=""></p> -->
				<hr>
				<!-- Post Excerpt -->
				<p><?php echo filter_var($postExcerpt, FILTER_SANITIZE_STRING); ?></p>
				<!-- Post Content -->
				<p><?php echo $parsedown->text(filter_var($postContent, FILTER_SANITIZE_STRING)); ?></p>
				<br>
				<!-- Post Tags -->
				<!-- <p><bt>TAGS: <a href="#">Wordpress</a> - <a href="#">Web Design</a></bt></p> -->
				<hr>
				<!-- Back Link -->
				<p><a href="<?php echo APP_URL . '/blog/'; ?>"># Back</a></p>
			</div>
		</div><!-- /.row -->
	</div> <!-- /.container -->
</div><!-- /.section -->
<!-- JS Scripts
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php require_once('footer.php'); ?>
