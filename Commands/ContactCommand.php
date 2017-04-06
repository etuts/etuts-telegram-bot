<?php

namespace Telegram\Bot\Commands;
require '../functions.php';

class ContactCommand extends Command
{
	protected $name = 'contact';
	protected $description = 'contact command';

	public function handle($arguments)
	{
		$text = 'لطفا پیام تان را بفرستید.';
		$this->replyWithMessage(compact('text'));
		// test these ones
		$this->getChat()->getId();
		$this->getUpdate();
		$this->getTelegram();

		db_set_state()
	}
}
