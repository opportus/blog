<?php

namespace App\Model;

use Core\Base\AbstractModel;
use Core\Base\ModelInterface;

/**
 * The post domain model...
 *
 * @version 0.0.1
 * @package App\Model
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class PostModel extends AbstractModel implements ModelInterface
{
	/**
	 * @var int $id
	 */
	protected $id;
	
	/**
	 * @var string $slug
	 */
	protected $slug;

	/**
	 * @var string $status
	 */
	protected $status;

	/**
	 * @var string $author
	 */
	protected $author;

	/**
	 * @var string $creationDatetime
	 */
	protected $creationDatetime;

	/**
	 * @var string $modificationDatetime
	 */
	protected $modificationDatetime;

	/**
	 * @var string $title
	 */
	protected $title;

	/**
	 * @var string $excerpt
	 */
	protected $excerpt;

	/**
	 * @var string $content
	 */
	protected $content;

	/**
	 * @var int $image
	 */
	protected $image;

	/*
	 |------------------------------------------------------------
	 | SETTERS
	 |------------------------------------------------------------
	 */
	
	/**
	 * Validates/Sanitizes/Sets id.
	 *
	 * @param  int $id
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
	 * Validates/Sanitizes/Sets slug.
	 *
	 * @param  string $slug
	 * @return bool
	 */
	public function setSlug($slug)
	{
		if ($this->toolbox->validateKey($slug)) {
			$this->slug = $this->toolbox->sanitizeKey($slug);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets status.
	 *
	 * @param  string $status
	 * @return bool
	 */
	public function setStatus($status)
	{
		if ($this->toolbox->validateKey($status)) {
			$this->status = $this->toolbox->sanitizeKey($status);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets author.
	 *
	 * @param  int $author
	 * @return bool
	 */
	public function setAuthor($author)
	{
		if ($this->toolbox->validateInt($author)) {
			$this->author = $this->toolbox->sanitizeInt($author);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets creation datetime.
	 *
	 * @param  string $creationDatetime
	 * @return bool
	 */
	public function setCreationDatetime($creationDatetime)
	{
		if ($this->toolbox->validateDatetime($creationDatetime, 'Y-m-d H:i:s')) {
			$this->creationDatetime = $this->toolbox->formatDatetime($creationDatetime, 'Y-m-d H:i:s');
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets modification datetime.
	 *
	 * @param  string $modificationDatetime
	 * @return bool
	 */
	public function setModificationDatetime($modificationDatetime)
	{
		if ($this->toolbox->validateDatetime($modificationDatetime, 'Y-m-d H:i:s')) {
			$this->modificationDatetime = $this->toolbox->formatDatetime($modificationDatetime, 'Y-m-d H:i:s');
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
	public function setTitle($title)
	{
		if ($this->toolbox->validateString($title)) {
			$this->title = $this->toolbox->sanitizeString($title);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets excerpt.
	 *
	 * @param  string $excerpt
	 * @return bool
	 */
	public function setExcerpt($excerpt)
	{
		if ($this->toolbox->validateString($excerpt)) {
			$this->excerpt = $this->toolbox->sanitizeString($excerpt);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Sanitizes/Sets content.
	 *
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $this->toolbox->escHtml($content);
	}

	/**
	 * Validates/Sanitizes/Sets image.
	 *
	 * @param  int $image
	 * @return bool
	 */
	public function setImage($image)
	{
		if ($this->toolbox->validateInt($image)) {
			$this->image = $this->toolbox->sanitizeInt($image);
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
	 * Gets slug.
	 *
	 * @return string $this->slug
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Gets status.
	 *
	 * @return string $this->status
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Gets author.
	 *
	 * @return int|object $this->author
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * Gets creation datetime.
	 *
	 * @return string $this->creationDatetime
	 */
	public function getCreationDatetime()
	{
		return $this->creationDatetime;
	}

	/**
	 * Gets modification datetime.
	 *
	 * @return string $this->modificationDatetime
	 */
	public function getModificationDatetime()
	{
		return $this->modificationDatetime;
	}

	/**
	 * Gets title.
	 *
	 * @return string $this->title
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Gets excerpt.
	 *
	 * @return string $this->excerpt
	 */
	public function getExcerpt()
	{
		return $this->excerpt;
	}

	/**
	 * Gets content.
	 *
	 * @return string $this->content
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Gets image.
	 *
	 * @return int|object $this->image
	 */
	public function getImage()
	{
		return $this->image;
	}
}

