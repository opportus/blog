<?php

namespace OC\Blog\Model;

use Hedo\Base\AbstractModel;
use Hedo\Base\ModelInterface;

/**
 * The post domain model...
 *
 * @version 0.0.1
 * @package OC\Blog\Model
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
	 * @var string $author
	 */
	protected $author;

	/**
	 * @var string $createdAt
	 */
	protected $createdAt;

	/**
	 * @var string $updatedAt
	 */
	protected $updatedAt;

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
		if (0 !== $id && $this->toolbox->validateInt($id)) {
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
		if ('' !== $slug && $this->toolbox->validateKey($slug)) {
			$this->slug = $this->toolbox->sanitizeKey($slug);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets author.
	 *
	 * @param  string $author
	 * @return bool
	 */
	public function setAuthor($author)
	{
		if ('' !== $author && $this->toolbox->validateString($author)) {
			$this->author = $this->toolbox->sanitizeString($author);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets creation datetime.
	 *
	 * @param  string $createdAt
	 * @return bool
	 */
	public function setCreatedAt($createdAt)
	{
		if ('' !== $createdAt && $this->toolbox->validateDatetime($createdAt, 'Y-m-d H:i:s')) {
			$this->createdAt = $this->toolbox->formatDatetime($createdAt, 'Y-m-d H:i:s');
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Validates/Sanitizes/Sets modification datetime.
	 *
	 * @param  string $updatedAt
	 * @return bool
	 */
	public function setUpdatedAt($updatedAt)
	{
		if ($this->toolbox->validateDatetime($updatedAt, 'Y-m-d H:i:s')) {
			$this->updatedAt = $this->toolbox->formatDatetime($updatedAt, 'Y-m-d H:i:s');
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
		if ($title && $this->toolbox->validateString($title)) {
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
	 * @param  string $content
	 * @return bool
	 */
	public function setContent($content)
	{
		$this->content = $this->toolbox->escHtml($content);
		return true;
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
	 * Gets author.
	 *
	 * @return string $this->author
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * Gets creation datetime.
	 *
	 * @return string $this->createdAt
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Gets modification datetime.
	 *
	 * @return string $this->updatedAt
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
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
}

