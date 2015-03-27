<?php

namespace App\Article;

use App\User\User;
use Nette;

class Article extends Nette\Object
{

	/** @var int */
	private $id;

	/** @var \App\User\User */
	private $author;

	/** @var string */
	private $title;

	/** @var string|null */
	private $content;

	/**
	 * @param \App\User\User $author
	 * @param string $title
	 * @param string|null $content
	 */
	public function __construct(User $author, $title, $content = null)
	{
		$this->id = hash('sha1', join('|', array(
			$author->getId(),
			$title,
			$content
		)));
		$this->author = $author;
		$this->title = (string) $title;
		$this->content = $content !== null ? $content : null;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return \App\User\User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return string|null
	 */
	public function getContent()
	{
		return $this->content;
	}

}
