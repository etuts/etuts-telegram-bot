<?php
namespace Telegram\Bot\Commands;
class ContactCommand extends Command
{
	protected $name = 'contact';
	protected $description = 'contact command';

	public function handle($arguments)
	{
	    $commands = $this->telegram->getCommands();

        $testit = 'sklfje';

        $this->replyWithMessage(compact('testit'));
	}
}
