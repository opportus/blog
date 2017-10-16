<?php

define('URL', '');
define('NAME', '');
define('EMAIL', '');
define('LOCALE', 'en-EN');
define('DATE_FORMAT', 'Y-m-d');
define('TIME_FORMAT', 'H:i:s');
define('DEBUG', 1);
define('SECRET_KEY', '&%3kdgismIT2ev+Gj=]-M4P4=H$/?lb:|ms u`rF,1c&I;k=U?w(57mw~`=pWM$>');
define('DATABASES', array(
	'default' => array(
		'dbHost'    => 'localhost',
		'dbName'    => '',
		'dbUser'    => '',
		'dbPass'    => '',
		'dbOptions' => array(
			'PDO:ATTR_PERSISTENT' => false,
		)
	)
));

