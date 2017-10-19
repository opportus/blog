<?php

require_once('../vendor/autoload.php');

// DIC
use Opportus\Container\Container;

// Middleware
use Opportus\Orm\PdoMySqlGateway;
use Opportus\Orm\EntityManager;
use Opportus\Http\Message\Request;
use Opportus\Http\Message\Response;
use Opportus\Http\Message\Stream;
use Opportus\Http\Message\Uri;
use Opportus\Router\Router;
use Opportus\Session\Session;

// Application
use Opportus\Blog\BlogController;
use Opportus\Blog\HomeController;
use Opportus\Blog\PostController;
use Opportus\Blog\NotFoundController;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * The application kernel...
 *
 * @version 0.0.1
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class AppKernel
{
	/**
	 * @var Container $container
	 */
	protected $container;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->init();
		$this->run();
	}

	/**
	 * Runs the application.
	 *
	 * @throws Exception 500 status when controller/action not found
	 */
	protected function run()
	{
		$endpoint = $this->container->get('Opportus\Router\Router')->resolve($this->container->get('Opportus\Http\Message\Request')->getUri()->getPath());

		try {
			if (! class_exists($endpoint['controller']) || ! method_exists($endpoint['controller'], $endpoint['action'])) {
				throw new Exception('[' . __CLASS__ . '::' . __FUNCTION__ . ']: Controller/Action not found! Check your routes and endpoints...');
			}

			$controller = $this->container->get($endpoint['controller']);

			call_user_func_array(
				array(
					$controller,
					$endpoint['action']
				),
				$endpoint['params']
			);

		} catch (Exception $e) {
			if (APP_DEBUG >= 1) {
				error_log($e->getMessage());
			}

			$this->container->get('Opportus\Http\Message\Response')->withStatus(500)->send();

			die();
		}
	}

	/**
	 * Initializes middleware and application.
	 */
	protected function init()
	{
		$this->container = new Container();
		$this->define();
		$this->registerMiddlewareDependencies();
		$this->registerApplicationEntities();
		$this->registerApplicationDependencies();
		$this->registerApplicationRoutes();
	}

	/**
	 * Defines constants.
	 */
	protected function define()
	{
		define('ROOT_DIR', dirname(dirname(__FILE__)));

		define('SRC_DIR',      ROOT_DIR . '/src');
		define('TEMPLATE_DIR', ROOT_DIR . '/src/template');
		define('VENDOR_DIR',   ROOT_DIR . '/vendor');
		define('WEBROOT_DIR',  ROOT_DIR . '/webroot');

		include_once(ROOT_DIR . '/src/config.php');
	}

	/**
	 * Registers middleware dependencies injections.
	 */
	protected function registerMiddlewareDependencies()
	{
		$container = $this->container;

		$container->set('Opportus\Orm\PdoMySqlGateway', function () {
			return new PdoMySqlGateway(
				APP_DATABASES
			);
		});

		$container->set('Opportus\Orm\EntityManager', function () {
			return new EntityManager();
		});

		$container->set('Opportus\Http\Message\Stream', function () {
			return new Stream(
				fopen('php://temp', 'r+')
			);
		});

		$container->set('Opportus\Http\Message\Uri', function () {
			return new Uri(
				$_SERVER['REQUEST_SCHEME'],
				isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '',
				isset($_SERVER['PHP_AUTH_USER_PW']) ? $_SERVER['PHP_AUTH_USER_PW'] : '',
				$_SERVER['HTTP_HOST'],
				(int) $_SERVER['SERVER_PORT'],
				current(explode('?', $_SERVER['REQUEST_URI'])),
				$_SERVER['QUERY_STRING'],
				''
			);
		});

		$container->set('Opportus\Http\Message\Request', function () use ($container) {
			return new Request(
				$_SERVER['SERVER_PROTOCOL'],
				$_SERVER['REQUEST_METHOD'],
				getAllHeaders(),
				$container->get('Opportus\Http\Message\Stream'),
				$container->get('Opportus\Http\Message\Uri')
			);
		});

		$container->set('Opportus\Http\Message\Response', function () use ($container) {
			return new Response(
				$container->get('Opportus\Http\Message\Request')->getProtocolVersion(),
				http_response_code(),
				array(),
				$container->get('Opportus\Http\Message\Stream')
			);
		});

		$container->set('Opportus\Router\Router', function () {
			return new Router();
		});

		$container->set('Opportus\Session\Session', function () {
			return new Session();
		});
	}

	/**
	 * Registers application dependencies injections.
	 */
	protected function registerApplicationDependencies()
	{
		$container = $this->container;

		$container->set('PHPMailer\PHPMailer\PHPMailer', function () {
			return new PHPMailer();
		});

		$container->set('Erusev\Parsedown', function () {
			return new Parsedown();
		});

		$container->set('Opportus\Blog\BlogController', function () use ($container) {
			return new BlogController(
				$container->get('Opportus\Session\Session'),
				$container->get('Opportus\Http\Message\Response'),
				$container->get('Opportus\Orm\EntityManager')
			);
		});

		$container->set('Opportus\Blog\HomeController', function () use ($container) {
			return new HomeController(
				$container->get('Opportus\Session\Session'),
				$container->get('Opportus\Http\Message\Response'),
				$container->get('PHPMailer\PHPMailer\PHPMailer')
			);
		});

		$container->set('Opportus\Blog\PostController', function () use ($container) {
			return new PostController(
				$container->get('Opportus\Session\Session'),
				$container->get('Opportus\Http\Message\Response'),
				$container->get('Opportus\Orm\EntityManager'),
				$container->get('Erusev\Parsedown')
			);
		});

		$container->set('Opportus\Blog\NotFoundController', function () use ($container) {
			return new NotFoundController(
				$container->get('Opportus\Http\Message\Response')
			);
		});
	}

	/**
	 * Registers application entities.
	 */
	protected function registerApplicationEntities()
	{
		$entity = array(
			'name'       => 'post',
			'properties' => array(
				'id'        => array(
					'validationCallback' => 'is_int',
					'table'              => 'post',
					'column'             => 'id'
				),
				'slug'      => array(
					'validationCallback' => function ($slug) {
						return ! preg_match('/[^a-z0-9_\-]/', $slug);
					},
					'table'              => 'post',
					'column'             => 'slug'
				),
				'author'    => array(
					'validationCallback' => function ($author) {
						return ($author === filter_var($author, FILTER_SANITIZE_STRING));
					},
					'table'              => 'post',
					'column'             => 'author'
				),
				'createdAt' => array(
					'validationCallback' => function ($createdAt) {
						return (bool) strtotime($createdAt);
					},
					'table'              => 'post',
					'column'             => 'created_at'
				),
				'updatedAt' => array(
					'validationCallback' => function ($updatedAt) {
						return (bool) strtotime($updatedAt);
					},
					'table'              => 'post',
					'column'             => 'updated_at'
				),
				'title'     => array(
					'validationCallback' => function ($title) {
						return ($title === filter_var($title, FILTER_SANITIZE_STRING));
					},
					'table'              => 'post',
					'column'             => 'title'
				),
				'excerpt'   => array(
					'validationCallback' => function ($excerpt) {
						return ($excerpt === filter_var($excerpt, FILTER_SANITIZE_STRING));
					},
					'table'              => 'post',
					'column'             => 'excerpt'
				),
				'content'   => array(
					'validationCallback' => function ($content) {
						return ($content === filter_var($content, FILTER_SANITIZE_STRING));
					},
					'table'              => 'post',
					'column'             => 'excerpt'
				)
			)
		);

		$this->container->get('Opportus\Orm\EntityManager')
			->register($entity, $this->container->get('Opportus\Orm\PdoMySqlGateway'));
	}

	/**
	 * Registers application routes.
	 */
	protected function registerApplicationRoutes()
	{
		$router = $this->container->get('Opportus\Router\Router');
		$routes = array(
			'#^/?$#' => array(
				'controller' => 'Opportus\Blog\HomeController',
				'action'     => 'view',
			),
			'#^/contact/?$#' => array(
				'controller' => 'Opportus\Blog\HomeController',
				'action'     => 'contact',
			),
			'#^/blog/?$#i' => array(
				'controller' => 'Opportus\Blog\BlogController',
				'action'     => 'view',
			),
			'#^/post/(.+)$#i' => array(
				'controller' => 'Opportus\Blog\PostController',
				'action'     => 'view',
			),
			'#^/cockpit/post/edit/(.*)$#i' => array(
				'controller' => 'Opportus\Blog\PostController',
				'action'     => 'edit',
			),
			'#^/cockpit/post/save/(.*)$#i' => array(
				'controller' => 'Opportus\Blog\PostController',
				'action'     => 'save',
			),
			'#^/cockpit/post/delete/(.+)$#i' => array(
				'controller' => 'Opportus\Blog\PostController',
				'action'     => 'delete',
			),
			'#^/(.+)#i' => array(
				'controller' => 'Opportus\Blog\NotFoundController',
				'action'     => 'view',
			),
		);

		foreach ($routes as $path => $endpoint) {
			$router->register($path, $endpoint);
		}
	}
}

