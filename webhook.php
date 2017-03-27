<?php 
require 'vendor/autoload.php';
use Telegram\Bot\Api;

$telegram = new Api('291144367:AAF66QzZVlw8MH0c8RyCD9hmnYnzRRrqMWs');

$updates = $telegram->getWebhookUpdates();

$response = $telegram->sendMessage([
  'chat_id' => '92454', 
  'text' => var_export($updates);
]);

// $messageId = $response->getMessageId();
?>