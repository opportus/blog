<?php

namespace OC\Blog;

use Hedo\Base\AbstractModule;
use Hedo\Base\ModuleInterface;

/**
 * The blog module...
 *
 * @version 0.0.1
 * @package OC\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class BlogModule extends AbstractModule implements ModuleInterface
{
	public function __construct()
	{
		define('OC_BLOG_DIR', dirname(__FILE__));
	}
}

