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
 * NOTES:
 * - You can use `$this` which refers to the DIC instance.
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(

	// Defaults...
	'App\Controller' => array(
		CORE . '/App/Controller',
	),
	'App\Model' => array(
		CORE . '/App/Model',
	),
	'App\View' => array(
		CORE . '/App/View',
	)
);

