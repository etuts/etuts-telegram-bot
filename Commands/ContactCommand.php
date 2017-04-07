<?php
require '../functions.php';

// namespace CustomCommands;
namespace Vendor\App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

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

		db_set_state($chat_id, CONTACT);
	}
}
