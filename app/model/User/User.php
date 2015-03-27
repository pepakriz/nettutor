<?php

namespace App\User;

use Nette;

class User extends Nette\Object
{

	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/**
	 * @param string $name
	 * @param int|null $id
	 */
	public function __construct($name, $id = null)
	{
		$this->name = (string) $name;
		$this->id = $id !== null ? $id : Nette\Utils\Random::generate();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

}
