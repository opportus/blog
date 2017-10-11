<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

use Hedo\Config;
use Hedo\Response;
use Hedo\Session;
use Hedo\Toolbox;

use \Exception;

/**
 * The homepage controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class HomeController extends AbstractBlogController implements ControllerInterface
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
	 * Constructor.
	 *
	 * @param Config   $config
	 * @param Toolbox  $toolbox
	 * @param Session  $session
	 * @param Response $response
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Response $response)
	{
		$this->init($config, $toolbox, $session, $response);
	}

	/**
	 * Initializes the blog controller.
	 *
	 * @param Config   $config
	 * @param Toolbox  $toolbox
	 * @param Session  $session
	 * @param Response $response
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Response $response)
	{
		$this->config   = $config;
		$this->toolbox  = $toolbox;
		$this->session  = $session;
		$this->response = $response;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$sessionToken = $this->session->setToken('contactFormToken');

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/home.php', array(
			'config'      => $this->config,
			'toolbox'     => $this->toolbox,

			'title'       => 'Clément Cazaud',
			'description' => 'Application Developer available for hire',
			'author'      => 'Clément CAZAUD',

			'token'       => $this->toolbox->generateToken('ContactFormToken', $sessionToken),

			'menuItems'   => array(
				array(
					'name'  => 'ABOUT',
					'link'  => '#about',
					'title' => '',
					'class' => 'scrollTo',
					'style' => '',
				),
				array(
					'name'  => 'PROJECTS',
					'link'  => '#projects',
					'title' => '',
					'class' => 'scrollTo',
					'style' => '',
				),
				array(
					'name'  => 'CONTACT',
					'link'  => '#contact',
					'title' => '',
					'class' => 'scrollTo',
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

	/**
	 * Contacts.
	 */
	public function contact()
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('ContactFormToken', $this->session->get('contactFormToken')))) {
			$this->session->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		$email   = $_POST['email'];
		$name    = $_POST['name'];
		$message = $_POST['message'];
		$errors  = array();

		if (empty($email)) {
			$errors['email'] = 'Required email';

		} elseif (! preg_match('/^[a-z0-9_.-]+@[a-z0-9_.-]{2,}\.[a-z]{2,4}$/', $email)) {
			$errors['email'] = 'Invalid email';
		}

		if (! preg_match('/^[\p{L}\s]{0,50}$/u', $name)) {
			$errors['name'] = 'Invalid name';
		}

		if (empty($message)) {
			$errors['message'] = 'Required message';

		} elseif (! preg_match('/^[\p{L}\s1-9"\'\(\)\:\;\,\.\?\!\+\-\@\=\°\~\*\/\\\$\€\£\µ\%]{0,50}$/u', $message)) {
			$errors['message'] = 'Invalid message';
		}

		if (empty($errors)) {
			$to       = $this->config->get('App', 'app', 'adminEmail');
			$subject  = 'Mail From ' . $this->config->get('App', 'app', 'name') . ' Contact Form';
			$headers  = 'From: "' . $name . '"<' . $email . ">\r\n";
			$headers .= 'Reply-to: "' . $name . '"<' . $email . ">\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset="utf8"' . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

			if (! mail($to, $subject, $message, $headers)) {
				$errors['sending'] = 'Your message has not been sent. Please try again.';
			}
		}


		if (empty($errors)) {
			$notif = 'I\'ll read your message soon, thanks !.';

		} else {
			$notif = implode(' - ', $errors);
		}

		$notif .= '...';

		$ajaxResponse = json_encode(array(
			'status'   => empty($errors),
			'notif'    => $notif,
			'errors'   => $errors,
			'redirect' => false,
			'refresh'  => false
		));

		$body = $this->response->getBody();
		$body->write($ajaxResponse);
		$this->response->withHeader('Content-Type', 'application/json')->withBody($body)->send();

		exit;
	}
}

