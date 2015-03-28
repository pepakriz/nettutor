<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 27.3.15
 * Time: 20:52
 */

namespace App\Components;


use Nette,
	App,
	Nette\Application\UI;

class ContactFactory extends UI\Control
{
	/**
	 * @var callable[]
	 */
	public $onBaseSend = [];

	function __construct()
	{

	}

	function createComponentBase()
	{
		$form = new UI\Form;

		$form->addText('email', 'Email')
			 ->setType('email')
			 ->setAttribute('placeholder', 'Email')
			 ->addRule($form::FILLED, 'Zapomněli jste vyplnit email')
			 ->addRule($form::EMAIL, 'Pole email neobsahuje email');

		$form->addTextArea('message', 'Zpráva')
			 ->addRule($form::FILLED, 'Zapomněli jste vyplnit zprávu');

		$form->addSubmit('send', 'Odeslat');

		$form->onSuccess[] = $this->sendBaseMessage;

		return $form;
	}
	public function sendBaseMessage(UI\Form $form)
	{
		$values = $form->getValues();

		//TODO some action

		if (count($this->onBaseSend)) {
			$this->onBaseSend($this, $form, $values->email, $values->message);
		}
	}
}

interface IContactFactory
{
	/**
	 * @return ContactFactory
	 */
	function create();
}
