<?php
namespace CustomCommands;
class ContactCommand extends Command
{
	protected $name = 'contact';
	protected $description = 'contact command';

	public function handle($arguments)
	{
		$this->replyWithMessage('text');
	}
}