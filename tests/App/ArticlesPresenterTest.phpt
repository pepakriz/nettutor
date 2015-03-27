<?php

namespace App;

use App\Article\ArticleFacade;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ArticlesPresenterTest extends Tester\TestCase
{

	/** @var \Nette\DI\Container */
	private $container;

	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @return mixed[]
	 */
	public function getDataActionData()
	{
		return array(
			array(
				'search' => null,
				'author' => null,
			),
			array(
				'search' => 'abc',
				'author' => null,
			),
			array(
				'search' => null,
				'author' => 1,
			),
			array(
				'search' => 'sobota',
				'author' => 2,
			),
		);
	}

	/**
	 * @param string|null $search
	 * @param integer|null $author
	 *
	 * @dataProvider getDataActionData
	 */
	public function testActionDefault($search, $author)
	{
		/** @var \App\Article\ArticleFacade $articlesFacade */
		$articlesFacade = $this->container->getByType(ArticleFacade::class);
		/** @var \Nette\Application\IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(Nette\Application\IPresenterFactory::class);
		/** @var \App\Presenters\ArticlesPresenter $presenter */
		$presenter = $presenterFactory->createPresenter('Articles');
		$presenter->autoCanonicalize = FALSE;

		$parameters = array(
			'action' => 'default',
		);

		if ($search !== null) {
			$parameters['search'] = $search;
		}

		if ($author !== null) {
			$parameters['author'] = $author;
		}

		$request = new Nette\Application\Request('Articles', 'GET', $parameters);
		/** @var \Nette\Application\Responses\TextResponse $response */
		$response = $presenter->run($request);

		Assert::type(Nette\Application\Responses\TextResponse::class, $response);
		Assert::type(Nette\Bridges\ApplicationLatte\Template::class, $response->getSource());

		$html = (string) $response->getSource();
		$html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('table.articles'));

		$articles = $articlesFacade->getArticlesByUserIdContains($author, $search);

		Assert::equal(count($articles), count($dom->xpath('//table[contains(@class, "articles")]/tbody/tr')));
		Assert::equal(4, count($dom->xpath('//table[contains(@class, "articles")]/tbody/tr[1]/td')));

		$id = 0;
		foreach ($articlesFacade->getArticlesByUserIdContains($author, $search) as $article) {
			Assert::same($article->getId(), (string) $dom->xpath('//table[contains(@class, "articles")]/tbody/tr[' . ($id + 1) . ']/td[1]')[0]);
			Assert::same((string) $article->getAuthor()->getName(), (string) $dom->xpath('//table[contains(@class, "articles")]/tbody/tr[' . ($id + 1) . ']/td[2]')[0]);
			Assert::same((string) $article->getTitle(), (string) $dom->xpath('//table[contains(@class, "articles")]/tbody/tr[' . ($id + 1) . ']/td[3]')[0]);
			Assert::same((string) $article->getContent(), (string) $dom->xpath('//table[contains(@class, "articles")]/tbody/tr[' . ($id + 1) . ']/td[4]')[0]);

			$id++;
		}
	}

}

$test = new ArticlesPresenterTest($container);
$test->run();
