<?php

namespace App;

use App\Presenters\BasePresenter;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ContactControlTest extends Tester\TestCase
{

	/** @var \Nette\DI\Container */
	private $container;

	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	public function testBasePresenterRegistration()
	{
		/** @var \Nette\Application\IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(Nette\Application\IPresenterFactory::class);
		/** @var \Nette\Application\UI\Presenter $presenter */
		$presenter = $presenterFactory->createPresenter('Homepage');
		$presenter->autoCanonicalize = FALSE;
		$request = new Nette\Application\Request('Homepage', 'GET', array(
			'action' => 'default',
		));
		$presenter->run($request);

		/** @var \Nette\Application\UI\Control $componentFactory */
		$componentFactory = $presenter->getComponent('contact');
		/** @var \Nette\Application\UI\Form $component */
		$component = $componentFactory->getComponent('base');
		$presenter->invalidLinkMode = 0;

		ob_start();
		$component->render();
		$html = ob_get_clean();

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('form'));
		Assert::true($dom->has('form input[type="email"]'));
		Assert::true($dom->has('form input[type="email"][data-nette-rules*=\'{"op":":filled","msg":\']'));
		Assert::true($dom->has('form input[type="email"][data-nette-rules*=\'{"op":":email","msg":\']'));

		Assert::true($dom->has('form textarea[required]'));
		Assert::true($dom->has('form textarea[required][data-nette-rules]'));
		Assert::true($dom->has('form textarea[required][data-nette-rules*=\'{"op":":filled","msg":\']'));

		Assert::true($dom->has('form input[type="submit"]'));
	}

}

class BasePresenterMock extends BasePresenter
{

}

$test = new ContactControlTest($container);
$test->run();
