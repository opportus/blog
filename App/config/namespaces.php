<?php

/**
 * The namespaces configuration...
 *
 * Register here your namespaces using the following syntax:
 *
 * // namespace        => directories
 *
 * 'MyApp\Controllers' => array(
 * 		'path/to/my/controllers',
 * 		'path/to/my/other/controllers',
 * );
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(

	// Defaults...
	'App\Controller' => array(
		APP . '/Controller',
	),
	'App\Model' => array(
		APP . '/Model',
	),
	'App\View' => array(
		APP . '/View',
	)
);

