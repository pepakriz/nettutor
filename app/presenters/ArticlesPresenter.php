<?php

namespace App\Presenters;

use App\Article\ArticleFacade;
use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class ArticlesPresenter extends BasePresenter
{

	/** @var string|null */
	private $search;

	/** @var string|null */
	private $author;

	/** @var \App\Article\ArticleFacade */
	private $articleFacade;

	public function __construct(ArticleFacade $articleFacade)
	{
		$this->articleFacade = $articleFacade;
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
		$this->template->articles = $this->articleFacade->getArticlesByUserIdContains(
			$this->author,
			$this->search
		);
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentFilterForm()
	{
		$authors = array();
		foreach ($this->articleFacade->getAuthors() as $author) {
			$authors[$author->getId()] = $author->getName();
		}

		$form = new Nette\Application\UI\Form();
		$form->addText('search', 'Hledat');
		$form->addSelect('author', 'Autor', $authors)
			->setPrompt('');
		$form->addSubmit('send', 'Filtrovat');
		$form->onSuccess[] = function (Nette\Application\UI\Form $form, Nette\Utils\ArrayHash $values) {
			$this->search = $values->search ?: null;
			$this->author = $values->author ?: null;
			$this->redirect('this');
		};
		$form->setDefaults(array(
			'search' => $this->search,
			'author' => $this->author,
		));

		return $form;
	}

	public function loadState(array $params)
	{
		parent::loadState($params);

		$this->search = isset($params['search']) ? $params['search'] : null;
		$this->author = isset($params['author']) ? (int) $params['author'] : null;
	}

	public function saveState(array & $params, $reflection = null)
	{
		parent::saveState($params, $reflection);

		if ($this->search !== null) {
			$params['search'] = $this->search;
		}

		if ($this->author !== null) {
			$params['author'] = $this->author;
		}
	}

}
