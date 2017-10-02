<?php

namespace App\Model;

use Hedo\Base\AbstractModel;
use Hedo\Base\ModelInterface;


/**
 * The image domain model...
 *
 * @version 0.0.1
 * @package App\Models
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class ImageModel extends AbstractModel implements ModelInterface
{
	/**
	 * @var int $id
	 */
	protected $id;

	/**
	 * @var string $url
	 */
	protected $url;

	/**
	 * @var string $title
	 */
	protected $title;

	/**
	 * @var string $alt
	 */
	protected $alt;

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
	protected function setId($id)
	{
		if ($this->toolbox->validateInt($id)) {
			$this->id = $this->toolbox->sanitizeInt($id);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets url.
	 *
	 * @param  string $url
	 * @return bool
	 */
	protected function setUrl($url)
	{
		if ($this->toolbox->validateUrl($url)) {
			$this->url = $this->toolbox->sanitizeUrl($url);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets title.
	 *
	 * @param  string $title
	 * @return bool
	 */
	protected function setTitle($title)
	{
		if ($this->toolbox->validateString($title)) {
			$this->title = $this->toolbox->sanitizeString($title);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets alt.
	 *
	 * @param  string $alt
	 * @return bool
	 */
	protected function setAlt($alt)
	{
		if ($this->toolbox->validateString($alt)) {
			$this->alt = $this->toolbox->sanitizeString($alt);
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
	 * @return int $id
	 */
	protected function getId()
	{
		return $this->id;
	}

	/**
	 * Gets url.
	 *
	 * @return string $url
	 */
	protected function getUrl()
	{
		return $this->url;
	}

	/**
	 * Gets title.
	 *
	 * @return string $title
	 */
	protected function getTitle()
	{
		return $this->title;
	}
	/**
	 * Gets alt.
	 *
	 * @return string $alt
	 */
	protected function getAlt()
	{
		return $this->alt;
	}
}

