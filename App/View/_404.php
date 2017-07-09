<?php

/**
 * The 404 view...
 *
 * @version 0.0.1
 * @package App\View
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>	
<?php require_once('part/header.php'); ?>
<div class="row">
	<div class="col-lg-12">
		<header class="jumbotron">
			<h1><?php echo $toolbox->escHtml($title); ?></h1>
		</header>
	</div>
</div>
<?php require_once('part/footer.php'); ?>
