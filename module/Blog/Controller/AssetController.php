<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

use Hedo\Config;
use Hedo\Response;

/**
 * The asset controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class AssetController extends AbstractBlogController implements ControllerInterface
{
	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Response $response
	 */
	protected $response;

	/**
	 * Constructor.
	 *
	 * @param Config   $config
	 * @param Response $response
	 */
	public function __construct(Config $config, Response $response)
	{
		$this->init($config, $response);
	}

	/**
	 * Initializes the asset controller.
	 *
	 * @param Config   $config
	 * @param Response $response
	 */
	protected function init(Config $config, Response $response)
	{
		$this->config   = $config;
		$this->response = $response;
	}

	/**
	 * Gets asset.
	 *
	 * @param string $type
	 * @param string $file
	 */
	public function get($type, $file)
	{
		$file = OC_BLOG_DIR . '/webroot/' . $type . '/' . $file;

		if (is_file($file)) {
			$fileExtension = substr($file, strrpos($file, '.') + 1);
			switch ($fileExtension) {
				case 'ico':
					$contentType = 'image/x-icon';
					break;
				case 'png':
					$contentType = 'image/png';
					break;
				case 'jpg':
					$contentType = 'image/jpg';
					break;
				case 'gif':
					$contentType = 'image/gif';
					break;
				case 'css':
					$contentType = 'text/css';
					break;
				case 'js':
					$contentType = 'text/javascript';
					break;
				
			}

			$this->response->withHeader('Content-Type', $contentType)->send();
			readfile($file);

			return;
		}

		$this->action404();
	}
}

