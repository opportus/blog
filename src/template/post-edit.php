<?php require_once('header.php'); ?>
<div class="section white py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<?php if ('' !== $postId) : ?>
					<div class="mb">
						<a class="btn btn-default" href="<?php echo APP_URL . '/post/' . $postId; ?>">View Post</a>
					</div>
				<?php endif; ?>
				<header>
					<h1><?php echo filter_var($metaTitle, FILTER_SANITIZE_STRING); ?></h1>
				</header>
				<hr>
				<form id="post-edit-form" role="form">
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" name="title" type="text" class="form-control" value="<?php echo filter_var($postTitle, FILTER_SANITIZE_STRING); ?>">
 			 		</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<input id="slug" name="slug" type="text" class="form-control" value="<?php echo filter_var($postSlug, FILTER_SANITIZE_STRING); ?>">
			  		</div>
					<div class="form-group">
						<label for="author">Author</label>
						<input id="author" name="author" type="text" class="form-control" value="<?php echo filter_var($postAuthor, FILTER_SANITIZE_STRING); ?>">
					</div>
					<div class="form-group">
						<label for="excerpt">Excerpt</label>
						<input id="excerpt" name="excerpt" type="text" class="form-control" value="<?php echo filter_var($postExcerpt, FILTER_SANITIZE_STRING); ?>">
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<small id="contentHelpInline" class="text-muted"> Use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">MarkDown syntax</a> to format your content</small>
						<textarea id="content" name="content" class="form-control" value="<?php echo filter_var($postContent, FILTER_SANITIZE_STRING); ?>" rows="20"><?php echo filter_var($postContent, FILTER_SANITIZE_STRING); ?></textarea>
					</div>
					<input id="token" name="token" type="hidden" value="<?php echo $token; ?>">
					<button class="form-send btn btn-default" ajaxaction="<?php echo APP_URL . '/cockpit/post/save/' . $postId; ?>">Save</button>
					<?php if ($postId) : ?>
						<button class="form-send btn btn-danger" ajaxaction="<?php echo APP_URL . '/cockpit/post/delete/' . $postId; ?>">Delete</button>
					<?php endif; ?>
				</form>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.section -->
<!-- JS Scripts
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Form AJAX -->
<script src="<?php echo APP_URL . '/js/form-ajax.min.js'; ?>"></script>
<?php require_once('footer.php'); ?>
