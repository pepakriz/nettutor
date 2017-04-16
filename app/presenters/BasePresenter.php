<?php

namespace App\Presenters;

use App\Components\NavigationControl;
use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function createComponentNavigation()
	{
		return new NavigationControl();
	}

}
