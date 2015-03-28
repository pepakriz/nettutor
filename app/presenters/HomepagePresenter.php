<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	public function createComponentContact()
	{
		$contact = $this->contactFactory->create();

		$contact->onBaseSend[] = function ($that, $form, $email, $message) {
			$this->flashMessage('Přijali jsme zprávu od: ' . $email . ', obsahující zprávu: ' . $message);
		};

		return $contact;
	}
}
