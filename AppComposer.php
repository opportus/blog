<?php

require_once('vendor/Hedo/Base/Abstract/AbstractComposer.php');

use Hedo\Base\AbstractComposer;
use Hedo\Base\ComposerInterface;

/**
 * Welcome Home...
 * This is the entry point of your application.
 * 
 * Initialize Hedo framework with:
 * $this->init();
 *
 * Then do your stuff...
 *
 * Then run your web app with:
 * $this->run();
 *
 * @see     vendor/Hedo/Base/Abstract/AbstractComposer.php
 * @see     vendor/Hedo/Base/Abstract/ComposerInterface.php
 * @version 0.0.1
 * @author  Clément Cazaud <opportus@gmail.com>
 */

class AppComposer extends AbstractComposer
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->init();

		// Your stuff...

		$this->run();
	}

	/**
	 * Register modules by returning their name into an array.
	 *
	 * @return array
	 */
	public function activateModules()
	{
		return array(
			'OC\Blog'
		);
	}
}

