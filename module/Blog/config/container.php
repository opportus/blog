<?php

/**
 * Register your dependencies here using the given array structure...
 */

return array(
	'OC\Blog\Model\PostFactory' => function () use (&$container) {
		return new OC\Blog\Model\PostFactory(
			$container->get('Hedo\Toolbox')
		);
	},
	'OC\Blog\Model\PostMapper' => function () use (&$container) {
		return new OC\Blog\Model\PostMapper(
			$container->get('Hedo\Gateway')
		);
	},
	'OC\Blog\Model\PostRepository' => function () use (&$container) {
		return new OC\Blog\Model\PostRepository(
			$container->get('OC\Blog\Model\PostFactory'),
			$container->get('OC\Blog\Model\PostMapper')
		);
	},
	'OC\Blog\Controller\BlogController' => function () use (&$container) {
		return new OC\Blog\Controller\BlogController(
			$container->get('Hedo\Config'),
			$container->get('Hedo\Toolbox'),
			$container->get('Hedo\Session'),
			$container->get('Hedo\Request'),
			$container->get('Hedo\Response'),
			array(
				'postRepository' => $container->get('OC\Blog\Model\PostRepository')
			)
		);
	},
	'OC\Blog\Controller\PostController' => function () use (&$container) {
		return new OC\Blog\Controller\PostController(
			$container->get('Hedo\Config'),
			$container->get('Hedo\Toolbox'),
			$container->get('Hedo\Session'),
			$container->get('Hedo\Request'),
			$container->get('Hedo\Response'),
			array(
				'postRepository' => $container->get('OC\Blog\Model\PostRepository')
			),
			array(
				'postFactory' => $container->get('OC\Blog\Model\PostFactory')
			)
		);
	},
	'OC\Blog\Controller\HomeController' => function () use (&$container) {
		return new OC\Blog\Controller\HomeController(
			$container->get('Hedo\Config'),
			$container->get('Hedo\Toolbox'),
			$container->get('Hedo\Session'),
			$container->get('Hedo\Request'),
			$container->get('Hedo\Response')
		);
	},
	'OC\Blog\Controller\_404Controller' => function () use (&$container) {
		return new OC\Blog\Controller\_404Controller(
			$container->get('Hedo\Config'),
			$container->get('Hedo\Toolbox'),
			$container->get('Hedo\Session'),
			$container->get('Hedo\Request'),
			$container->get('Hedo\Response')
		);
	},
);

