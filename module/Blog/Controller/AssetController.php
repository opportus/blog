<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

/**
 * The asset controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class AssetController extends AbstractBlogController implements ControllerInterface
{
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

