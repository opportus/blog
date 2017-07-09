<?php

/**
 * The Dependency Injection Container configuration...
 *
 * Set here the DIC registry you want by default using the following syntax:
 *
 * 'alias' => function () {
 * 		return new App\MyClass($this->get('Dependency1'), 'dependency2');
 * }
 *
 * This way, you can redefine the instances to be loaded at core initialization.
 * For example, you can redefine the default data Gateway as follow:
 *
 * 'Gateway' => function () {
 *		return new App\MyAdaptaters\DataGateway($this->get('Config'), $this->get('Toolbox'));
 * }
 *
 * The DIC will then inject your DataGateway in instances depending on the 'Gateway' alias.
 *
 * NOTES:
 * - You can use `$this` which refers to the DIC instance.
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(

	'App\Controller\_404Controller' => function () {
		return new App\Controller\_404Controller($this->get('Config'), $this->get('Toolbox'), $this->get('Request'), $this->get('Response'), $this);
	},
	'App\Controller\HomeController' => function () {
		return new App\Controller\HomeController($this->get('Config'), $this->get('Toolbox'), $this->get('Request'), $this->get('Response'), $this);
	},
	'App\Controller\BlogController' => function () {
		return new App\Controller\BlogController($this->get('Config'), $this->get('Toolbox'), $this->get('Request'), $this->get('Response'), $this);
	},
	'App\Controller\PostController' => function () {
		return new App\Controller\PostController($this->get('Config'), $this->get('Toolbox'), $this->get('Request'), $this->get('Response'), $this);
	},
	'App\Model\ImageMapper' => function () {
		return new App\Model\ImageMapper($this->get('Gateway'), 'images');
	},
	'App\Model\UserMapper' => function () {
		return new App\Model\UserMapper($this->get('Gateway'), 'users');
	},
	'App\Model\PostMapper' => function () {
		return new App\Model\PostMapper($this->get('Gateway'), 'posts', array('UserMapper' => $this->get('App\Model\UserMapper')));
	},
	'App\Model\ImageRepository' => function () {
		return new App\Model\ImageRepository($this, $this->get('App\Model\ImageMapper'));
	},
	'App\Model\UserRepository' => function () {
		return new App\Model\UserRepository($this, $this->get('App\Model\UserMapper'));
	},
	'App\Model\PostRepository' => function () {
		return new App\Model\PostRepository($this, $this->get('App\Model\PostMapper'));
	},
);

