<?php

namespace Opportus\Blog;

use Opportus\Session\Session;

use Psr\Http\Message\ResponseInterface;

use \Exception;

/**
 * The homepage controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class HomeController extends AbstractController
{
	/**
	 * @var Session $session
	 */
	protected $session;

	/**
	 * @var ResponseInterface $response
	 */
	protected $response;

	/**
	 * Constructor.
	 *
	 * @param Session           $session
	 * @param ResponseInterface $response
	 */
	public function __construct(Session $session, ResponseInterface $response)
	{
		$this->session  = $session;
		$this->response = $response;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$sessionToken = $this->session->set('contactFormToken', hash_hmac('sha256', bin2hex(random_bytes(32)), SECRET_KEY));

		$body = $this->response->getBody();

		$body->write($this->render(TEMPLATE_DIR . '/home.php', array(
			'metaTitle'       => 'Clément CAZAUD',
			'metaDescription' => 'Application Developer available for hire',
			'metaAuthor'      => 'Clément CAZAUD',
			'token'           => hash_hmac('sha256', 'contactFormToken', $sessionToken),
			'menuItems'       => array(
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
					'link'  => URL . '/blog/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'WRITE',
					'link'  => URL . '/cockpit/post/edit/',
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
		if (! isset($_POST['token']) || ! hash_equals($_POST['token'], hash_hmac('sha256', 'contactFormToken', $this->session->get('contactFormToken')))) {
			$this->session->destroy();

			throw new Exception('[' . __CLASS__ . '::' . __FUNCTION__ . ']: Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
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
			$to       = EMAIL;
			$subject  = 'Mail From ' . NAME . ' Contact Form';
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
			$notif = 'I\'ll read your message soon, thanks !';

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

