<?php

/**
 * The post edition view...
 *
 * @version 0.0.1
 * @package App\CMS\View
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
<?php require_once('part/header.php'); ?>
<div>
	<?php if ('' !== $failureMessage) : ?>
		<div class="alert alert-danger">
			<?php echo $toolbox->sanitizeString($failureMessage); ?>
		</div>
	<?php elseif ('' !== $successMessage) :?>
		<div class="alert alert-success">
			<?php echo $toolbox->sanitizeString($successMessage); ?>
		</div>
	<?php endif;?>
	<?php if ('' !== $postId) : ?>
	<div>
		<a class="btn btn-default" href="<?php echo $toolbox->sanitizeUrl($config->get('app', 'url') . '/post/' . $postId); ?>">View the Post</a>
	</div>
	<?php endif; ?>
	<header>
		<h1><?php echo $toolbox->sanitizeString($title); ?></h1>
	</header>
	<hr>
	<form method="post">
		<div class="form-group">
			<label for="postTitle">Title</label>
			<input id="postTitle" name="postTitle" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postTitle); ?>">
  		</div>
		<div class="form-group">
			<label for="postSlug">Slug</label>
			<input id="postSlug" name="postSlug" type="text" class="form-control" value="<?php echo $toolbox->sanitizeKey($postSlug); ?>">
  		</div>
		<div class="form-group">
			<label for="postStatus">Status</label>
			<input id="postStatus" name="postStatus" type="text" class="form-control" value="<?php echo $toolbox->sanitizeKey($postStatus); ?>">
		</div>
		<div class="form-group">
			<label for="postAuthor">Author ID</label>
			<input id="postAuthor" name="postAuthor" type="text" class="form-control" value="<?php echo $toolbox->sanitizeKey($postAuthor); ?>">
		</div>
		<div class="form-group">
			<label for="postExcerpt">Excerpt</label>
			<input id="postExcerpt" name="postExcerpt" type="text" class="form-control" value="<?php echo $toolbox->sanitizeString($postExcerpt); ?>">
		</div>
		<div class="form-group">
			<label for="postContent">Content</label>
			<textarea id="postContent" name="postContent" class="form-control" value="<?php echo $toolbox->sanitizeString($postContent); ?>" rows="20"><?php
				echo $toolbox->sanitizeString($postContent);
			?></textarea>
		</div>
		<div>
			<input id="token" name="token" type="hidden" value="<?php echo $token; ?>">
			<button type="submit" class="btn btn-default" formaction="<?php echo $toolbox->sanitizeUrl($config->get('app', 'url') . '/cockpit/post/save/' . $postId); ?>">Save</button>
			<?php if ($postId) : ?>
				<button type="submit" class="btn btn-danger" formaction="<?php echo $toolbox->sanitizeUrl($config->get('app', 'url') . '/cockpit/post/delete/' . $postId); ?>">Delete</button>
			<?php endif; ?>
		</div>
	</form>
</div>
<?php require_once('part/footer.php'); ?>
