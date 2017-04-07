<?php
// requirements
require 'vendor/autoload.php';
use Telegram\Bot\Api;

// connecting
$telegram = new Api('291144367:AAF66QzZVlw8MH0c8RyCD9hmnYnzRRrqMWs');

// get user message
$updates = $telegram->getWebhookUpdates();
$chat_id = (int) $updates->getMessage()->getChat()->getId();
$text = $updates->getMessage()->getText();

$telegram->addCommand(Telegram\Bot\Commands\HelpCommand::class);
$telegram->addCommand(CustomCommands\ContactCommand::class);
$update = $telegram->commandsHandler(true);

$telegram->sendMessage([
  'chat_id' => $chat_id,
  'text' => $text
]);

?>
