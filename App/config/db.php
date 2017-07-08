<?php

/**
 * The databases configuration...
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(
	'default' => array(
		'dbHost'    => 'localhost',
		'dbName'    => '',
		'dbUser'    => '',
		'dbPass'    => '',

		// The options of your default database connection...
		'dbOptions' => array(
			'PDO:ATTR_PERSISTENT' => false,
		)
	),

	// Add here your other databases credentials (if any)...
);

