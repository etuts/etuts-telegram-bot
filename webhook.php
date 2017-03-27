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

// connect to database
$db = mysqli_connect('localhost','ZMYbZ5jIaqW5SYi','bzJcaSbjlgtp9K9','etutsTeleRobot') or die('Error connecting to MySQL server.');

// get chat state from database
$result = mysqli_query($db, "SELECT * FROM `chats` WHERE chat_id = '$chat_id' ");
$state = "ef";
if( mysqli_num_rows($result) == 0) {
    mysqli_query($db, "INSERT INTO `chats` (chat_id, state, last_message) VALUES ('$chat_id', '0', '$text') ");
	$state = "added";
}
else {
	$result = mysqli_query($db, "SELECT `state` FROM `chats` WHERE chat_id = '$chat_id' ");
	$state = $result->fetch_assoc()['state'];
}

// 

$telegram->sendMessage([
  'chat_id' => $chat_id,
  'text' => $state
]);

// close database
mysqli_close($db);

?>