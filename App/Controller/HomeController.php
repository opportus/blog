<?php

namespace App\Controller;

use Hedo\Core\Base\ControllerInterface;

/**
 * The homepage controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class HomeController extends AppController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$sessionToken = $this->request->getSession()->setToken('contactFormToken');

		$body = $this->render('home', array(
			'title'              => '',
			'description'        => '',
			'author'             => '',
			'failureNotif'       => $this->request->getSession()->get('contactFormFailureNotification'),
			'successNotif'       => $this->request->getSession()->get('contactFormSuccessNotification'),
			'email'              => $this->request->getSession()->get('contactFormEmail'),
			'name'               => $this->request->getSession()->get('contactFormName'),
			'message'            => $this->request->getSession()->get('contactFormMessage'),
			'token'              => $this->toolbox->generateToken('HomeController/view', $sessionToken),

			'menuItems'          => $this->config->getApp('frontMenuItems'),
			'menuItemsRightHand' => $this->config->getApp('frontMenuItemsRightHand'),
		));

		$this->response->setBody($body);
		$this->response->send();

		$this->request->getSession()->unset('contactFormEmail');
		$this->request->getSession()->unset('contactFormName');
		$this->request->getSession()->unset('contactFormMessage');
		$this->request->getSession()->unset('contactFormFailureNotification');
		$this->request->getSession()->unset('contactFormSuccessNotification');
	}

	/**
	 * Contacts.
	 */
	public function contact()
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('HomeController/view', $this->request->getSession()->get('contactFormToken')))) {
			$this->request->getSession()->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		$email   = $_POST['email'];
		$name    = $_POST['name'];
		$message = $_POST['message'];
		$errors  = array();

		if (! preg_match('/^[a-z0-9_.-]+@[a-z0-9_.-]{2,}\.[a-z]{2,4}$/', $email)) {
			$errors[] = 'Invalid Email';
		}

		if (! preg_match('/^[\p{L}\s]{0,50}$/u', $name)) {
			$errors[] = 'Invalid Name';
		}

		if (! preg_match('/^[\p{L}\s1-9"\'\(\)\:\;\,\.\?\!\+\-\@\=\°\~\*\/\\\$\€\£\µ\%]{0,50}$/u', $message)) {
			$errors[] = 'Invalid Message';
		}

		if ($errors) {
			$this->request->getSession()->set('contactFormFailureNotification', implode(' - ', $errors));
			
		} else {
			$to       = $this->config->getApp('adminEmail');
			$subject  = 'Mail From ' . $this->config->getApp('name') . ' Contact Form';
			$headers  = 'From: "' . $name . '"<' . $email . ">\r\n";
			$headers .= 'Reply-to: "' . $name . '"<' . $email . ">\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset="utf8"' . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

			if (mail($to, $subject, $message, $headers)) {
				$this->request->getSession()->set('contactFormSuccessNotification', 'Your message has successfully been sent. We\'ll reply to you ASAP.');

			} else {
				$this->request->getSession()->set('contactFormFailureNotification', 'Your message has not been sent. Please try again.');
			}
		}

		$this->request->getSession()->set('contactFormEmail', $email);
		$this->request->getSession()->set('contactFormName', $name);
		$this->request->getSession()->set('contactFormMessage', $message);
		$this->response->setHeaders('Location: ' . $this->config->getApp('url'));
		$this->response->send();

		exit;
	}
}

