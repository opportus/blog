<?php

define('APP_URL', '');
define('APP_NAME', '');
define('APP_LOCALE', 'en-EN');
define('APP_DATE_FORMAT', 'Y-m-d');
define('APP_TIME_FORMAT', 'H:i:s');
define('APP_DEBUG', 0);
define('APP_SECRET_KEY', '&%3kVgismIT2ev+Gj=]-M4P4=H$/?lb:|ms u`rF,1c&I;k=U?w(57mw~`=pWM$>');
define('APP_DATABASES', array(
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
define('APP_EMAIL_ADDRESS', '');
define('APP_SMTP_AUTH', true);
define('APP_SMTP_SECURE', 'tls');
define('APP_SMTP_HOST', 'smtp.gmail.com');
define('APP_SMTP_PORT', 587);
define('APP_SMTP_USERNAME', '');
define('APP_SMTP_PASSWORD', '');
