<?php require_once('header.php'); ?>
<div class="section white py">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<?php if ('' !== $postId) : ?>
					<div class="mb">
						<a class="btn btn-default" href="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/post/' . $postId); ?>">View Post</a>
					</div>
				<?php endif; ?>
				<header>
					<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
				</header>
				<hr>
				<form id="post-edit-form" role="form">
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" name="title" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postTitle); ?>">
 			 		</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<input id="slug" name="slug" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postSlug); ?>">
			  		</div>
					<div class="form-group">
						<label for="author">Author</label>
						<input id="author" name="author" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postAuthor); ?>">
					</div>
					<div class="form-group">
						<label for="excerpt">Excerpt</label>
						<input id="excerpt" name="excerpt" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postExcerpt); ?>">
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<small id="contentHelpInline" class="text-muted"> Use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">MarkDown syntax</a> to format your content</small>
						<textarea id="content" name="content" class="form-control" value="<?php echo $toolbox->sanitizeString($postContent); ?>" rows="20"><?php echo $toolbox->sanitizeString($postContent); ?></textarea>
					</div>
					<input id="token" name="token" type="hidden" value="<?php echo $token; ?>">
					<button class="form-send btn btn-default" ajaxaction="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/cockpit/post/save/' . $postId); ?>">Save</button>
					<?php if ($postId) : ?>
						<button class="form-send btn btn-danger" ajaxaction="<?php echo $toolbox->sanitizeUrl($config->get('App', 'app', 'url') . '/cockpit/post/delete/' . $postId); ?>">Delete</button>
					<?php endif; ?>
				</form>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.section -->
<?php require_once('footer.php'); ?>
