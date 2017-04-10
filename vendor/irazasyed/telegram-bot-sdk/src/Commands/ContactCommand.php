<?php
namespace Telegram\Bot\Commands;
class ContactCommand extends Command
{
	protected $name = 'contact';
	protected $description = 'contact command';

	public function handle($arguments)
	{
	    $this->replyWithMessage(['text' => 'test']);
	}
}
