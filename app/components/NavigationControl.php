<?php

namespace App\Components;

use Nette;

class NavigationControl extends Nette\Application\UI\Control
{

	public function render()
	{
		$this->template->setFile(substr($this->getReflection()->getFileName(), 0, -4) . '.latte');
		$this->template->render();
	}

}
