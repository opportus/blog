<?php

/**
 * The footer template...
 *
 * @version 0.0.1
 * @package App\View\Part
 * @author  Clément Cazaud <opportus@gmail.com>
 */ ?>
		<!-- Footer -->
		<hr>
		<footer>
			<div class="row">
				<div class="col-lg-12">
					<p>&copy; <?php echo date('Y') . ' ' . $toolbox->sanitizeString($config->get('app', 'name')); ?></p>
				</div>
			</div>
			<!-- /.row -->
		</footer>
		<!-- /.footer -->
	</div>
	<!-- /.container -->
	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
