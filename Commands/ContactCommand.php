<?php

namespace Telegram\Bot\Commands;

/**
 * Class ContactCommand.
 */
class ContactCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'contact';

    /**
     * @var string Command Description
     */
    protected $description = 'contact command';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('text'));
    }
}
