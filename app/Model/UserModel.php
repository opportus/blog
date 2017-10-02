<?php

namespace App\Model;

use Hedo\Base\AbstractModel;
use Hedo\Base\ModelInterface;

/**
 * The user domain model...
 *
 * @version 0.0.1
 * @package App\Model
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class UserModel extends AbstractModel implements ModelInterface
{
	/**
	 * @var int $id
	 */
	protected $id;

	/**
	 * @var string $login
	 */
	protected $login;

	/**
	 * @var string $email
	 */
	protected $email;

	/**
	 * @var string $password
	 */
	protected $password;

	/**
	 * @var string $registrationDatetimed
	 */
	protected $registrationDatetime;

	/**
	 * @var string $role
	 */
	protected $role;

	/**
	 * @var string $firstName
	 */
	protected $firstName;

	/**
	 * @var string $secondName
	 */
	protected $secondName;

	/*
	 |------------------------------------------------------------
	 | SETTERS
	 |------------------------------------------------------------
	 */

	/**
	 * Validates/Sanitizes/Sets id.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function setId($id)
	{
		if ($this->toolbox->validateInt($id)) {
			$this->id = $this->toolbox->sanitizeInt($id);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets login.
	 *
	 * @param  string $login
	 * @return bool
	 */
	public function setLogin($login)
	{
		if ($this->toolbox->validateKey($login)) {
			$this->login = $this->toolbox->sanitizeKey($login);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets email.
	 *
	 * @param  string $email
	 * @return bool
	 */
	public function setEmail($email)
	{
		if ($this->toolbox->validateEmail($email)) {
			$this->email = $this->toolbox->sanitizeEmail($email);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets password.
	 *
	 * @param  string $password
	 * @return bool
	 */
	public function setPassword($password)
	{
		if ($this->toolbox->validateString($password)) {
			$this->password = $this->toolbox->sanitizeString($password);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets registration datetime.
	 *
	 * @param  string $registrationDatetime
	 * @return bool
	 */
	public function setRegistrationDatetime($registrationDatetime)
	{
		if ($this->toolbox->validateDatetime($registrationDatetime, 'Y-m-d H:i:s')) {
			$this->registrationDatetime = $this->toolbox->formatDatetime($registrationDatetime, 'Y-m-d H:i:s' );
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets role.
	 *
	 * @param  string $role
	 * @return bool
	 */
	public function setRole($role)
	{
		if ($this->toolbox->validateKey($role)) {
			$this->role = $this->toolbox->SanitizeKey($role);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets first name.
	 *
	 * @param  string $firstName
	 * @return bool
	 */
	public function setFirstName($firstName)
	{
		if ($this->toolbox->validateString($firstName)) {
			$this->firstName = $this->toolbox->sanitizeString($firstName);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets second name.
	 *
	 * @param  string $secondName
	 * @return bool
	 */
	public function setSecondName($secondName)
	{
		if ($this->toolbox->validateString($secondName)) {
			$this->secondName = $this->toolbox->sanitizeString($secondName);
			return true;

		} else {
			return false;
		}
	}

	/*
	 |------------------------------------------------------------
	 | GETTERS
	 |------------------------------------------------------------
	 */

	/**
	 * Gets id.
	 *
	 * @return int $this->id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Gets login.
	 *
	 * @return string $this->login
	 */
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * Gets email.
	 *
	 * @return string $this->email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Gets password.
	 *
	 * @return string $this->password
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Gets Registration datetime.
	 *
	 * @return string $this->registrationDatetime
	 */
	public function getRegistrationDatetime()
	{
		return $this->registrationDatetime;
	}

	/**
	 * Gets role.
	 *
	 * @return string $this->role
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * Gets first name.
	 *
	 * @return string $this->firstName
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * Gets second name.
	 *
	 * @return string $this->secondName
	 */
	public function getSecondName()
	{
		return $this->secondName;
	}
}

