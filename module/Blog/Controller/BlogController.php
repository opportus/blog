<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

use Hedo\Config;
use Hedo\Toolbox;
use Hedo\Session;
use Hedo\Response;

use OC\Blog\Model\PostRepository;

/**
 * The blog controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class BlogController extends AbstractBlogController implements ControllerInterface
{
	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * @var Session $session
	 */
	protected $session;

	/**
	 * @var Response $response
	 */
	protected $response;

	/**
	 * @var PostRepository $postRepository
	 */
	protected $postRepository;

	/**
	 * Constructor.
	 *
	 * @param Config         $config
	 * @param Toolbox        $toolbox
	 * @param Session        $session
	 * @param Response       $response
	 * @param PostRepository $postRepository
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Response $response, PostRepository $postRepository)
	{
		$this->init($config, $toolbox, $session, $response, $postRepository);
	}

	/**
	 * Initializes the blog controller.
	 *
	 * @param Config         $config
	 * @param Toolbox        $toolbox
	 * @param Session        $session
	 * @param Response       $response
	 * @param PostRepository $postRepository
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Response $response, PostRepository $postRepository)
	{
		$this->config         = $config;
		$this->toolbox        = $toolbox;
		$this->session        = $session;
		$this->response       = $response;
		$this->postRepository = $postRepository;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$posts = array();

		foreach ($this->postRepository->get() as $post) {
			$posts[] = array(
				'title'    => $post->getTitle(),
				'excerpt'  => $post->getExcerpt(),
				'datetime' => $post->getUpdatedAt() !== null ? $this->toolbox->formatDatetime($post->getUpdatedAt()) : $this->toolbox->formatDatetime($post->getCreatedAt()),
				'id'       => $post->getId(),
			);
		}

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/blog.php', array(
			'config'      => $this->config,
			'toolbox'     => $this->toolbox,

			'title'       => 'My Tech Blog',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam pellentesque sem id molestie. Pellentesque nec lectus a sapien posuere sollicitudin. Vivamus nec tortor turpis.',
			'author'      => 'Clément Cazaud',

			'posts'       => $posts,

			'menuItems'   => array(
				array(
					'name'  => 'ABOUT',
					'link'  => $this->config->get('App', 'app', 'url') . '/#about',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'PROJECTS',
					'link'  => $this->config->get('App', 'app', 'url') . '/#projects',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'CONTACT',
					'link'  => $this->config->get('App', 'app', 'url') . '/#contact',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'BLOG',
					'link'  => $this->config->get('App', 'app', 'url') . '/blog/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'WRITE',
					'link'  => $this->config->get('App', 'app', 'url') . '/cockpit/post/edit/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
			),
		)));

		$this->response->withBody($body)->send();
	}
}

