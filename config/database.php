<?php

/**
 * Register your databases credentials here using the following array structure...
 *
 * @version 0.0.1
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(
	'default' => array(
		'dbHost'    => 'localhost',
		'dbName'    => 'clemc',
		'dbUser'    => 'clemc',
		'dbPass'    => 'DnmCK301',
		'dbOptions' => array(
			'PDO:ATTR_PERSISTENT' => false,
		)
	),

	// Add here your other databases (if any)...
);

