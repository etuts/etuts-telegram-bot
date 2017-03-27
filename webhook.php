<?php 
require 'vendor/autoload.php';
use Telegram\Bot\Api;

$telegram = new Api('291144367:AAF66QzZVlw8MH0c8RyCD9hmnYnzRRrqMWs');
$response = $telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();
echo $firstName;
?>