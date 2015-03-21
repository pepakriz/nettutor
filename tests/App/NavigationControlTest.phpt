<?php

namespace App;

use App\Presenters\BasePresenter;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class NavigationControlTest extends Tester\TestCase
{

	/** @var \Nette\DI\Container */
	private $container;

	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	public function testBasePresenterRegistration()
	{
		/** @var \App\BasePresenterMock $presenter */
		$presenter = $this->container->createInstance(BasePresenterMock::class);
		$this->container->callInjects($presenter);

		/** @var \Nette\Application\UI\Control $component */
		$component = $presenter->getComponent('navigation', false);

		Assert::type(Nette\Application\UI\Control::class, $component);

		/** @var \Nette\Application\IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(Nette\Application\IPresenterFactory::class);
		/** @var \Nette\Application\UI\Presenter $presenter */
		$presenter = $presenterFactory->createPresenter('Homepage');
		$presenter->autoCanonicalize = FALSE;
		$request = new Nette\Application\Request('Homepage', 'GET', array(
			'action' => 'default',
		));
		$presenter->run($request);

		$component = $presenter->getComponent('navigation');

		ob_start();
		$component->render();
		$html = ob_get_clean();

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('ul li a[href="/"]'));
		Assert::true($dom->has('ul li a[href="/contact"]'));
	}

}

class BasePresenterMock extends BasePresenter
{

}

$test = new NavigationControlTest($container);
$test->run();
