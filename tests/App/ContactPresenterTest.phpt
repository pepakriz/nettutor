<?php

namespace App;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ContactPresenterTest extends Tester\TestCase
{

	/** @var \Nette\DI\Container */
	private $container;

	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	public function testActionDefault()
	{
		/** @var \Nette\Application\IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(Nette\Application\IPresenterFactory::class);
		/** @var \Nette\Application\UI\Presenter $presenter */
		$presenter = $presenterFactory->createPresenter('Contact');
		$presenter->autoCanonicalize = FALSE;

		$request = new Nette\Application\Request('Contact', 'GET', array(
			'action' => 'default',
		));
		/** @var \Nette\Application\Responses\TextResponse $response */
		$response = $presenter->run($request);

		Assert::type(Nette\Application\Responses\TextResponse::class, $response);
		Assert::type(Nette\Bridges\ApplicationLatte\Template::class, $response->getSource());

		$html = (string) $response->getSource();
		$html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('h1'));
		Assert::same('Contact', (string) $dom->find('h1')[0]);
		Assert::true($dom->has('a[href="/"]'));
	}

}

$test = new ContactPresenterTest($container);
$test->run();
