<?php

namespace App\Article;

use App\User\User;
use Nette;

class ArticleFacade extends Nette\Object
{

	/**
	 * @return \App\Article\Article[]
	 */
	public function getArticles()
	{
		return $this->createTestData();
	}

	/**
	 * @return \App\User\User[]
	 */
	public function getAuthors()
	{
		return array(
			new User('Tomáš', 1),
			new User('Adam', 2),
		);
	}

	/**
	 * @param int|null $userId
	 * @param string|null $search
	 * @return \App\Article\Article[]
	 */
	public function getArticlesByUserIdContains($userId = null, $search = null)
	{
		return array_filter($this->createTestData(), function (Article $article) use ($userId, $search) {
			return (
				($userId === null || $article->getAuthor()->getId() === $userId)
				&& ($search === null || strpos($article->getTitle(), $search) !== false || strpos($article->getContent(), $search) !== false)
			);
		});
	}

	/**
	 * @return \App\Article\Article[]
	 */
	private function createTestData()
	{
		$authors = $this->getAuthors();

		$articles = array();
		$articles[] = new Article($authors[0], 'Jak na Doctrine');
		$articles[] = new Article($authors[0], 'JavaScript', 'abc def');
		$articles[] = new Article($authors[1], 'Nette - blog za 10 minut', 'x y z');
		$articles[] = new Article($authors[1], 'Poslední sobota', 'setkání vývojářů');
		$articles[] = new Article($authors[1], 'Quick start', 'začneme tím, že ...');

		return $articles;
	}

}
