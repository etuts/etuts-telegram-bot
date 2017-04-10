<?php
namespace Telegram\Bot\Commands;
class ContactCommand extends Command
{
	protected $name = 'contact';
	protected $description = 'contact command';

	public function handle($arguments)
	{
	    $commands = $this->telegram->getCommands();

        $testit = '';
        foreach ($commands as $name => $handler) {
            $testit .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('testit'));
	}
}
