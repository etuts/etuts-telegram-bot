<?php 
// requirements
require 'vendor/autoload.php';
use Telegram\Bot\Api;

// connecting
$telegram = new Api('291144367:AAF66QzZVlw8MH0c8RyCD9hmnYnzRRrqMWs');

// get user message
$updates = $telegram->getWebhookUpdates();
$chat_id = $updates->getMessage()->getChat()->getId();
$text = $updates->getMessage()->getText();

// connect to database
$db = mysqli_connect('localhost','ZMYbZ5jIaqW5SYi','bzJcaSbjlgtp9K9','etutsTeleRobot') or die('Error connecting to MySQL server.');

// check chat state
$result = mysql_query("SELECT * FROM chats WHERE chat_id ='$chat_id' ");
$state = "nothing";
if( mysql_num_rows($result) == 0) {
    mysql_query("INSERT INTO chats (chat_id, state, last_message) VALUES ('$chat_id', '0', '$text') ");
	$state = "added";
}
/*else
	$state = mysql_query("SELECT state from chats where chat_id = $chat_id");*/

$telegram->sendMessage([
  'chat_id' => $chat_id,
  'text' => $state
]);

// close database
mysqli_close($db);

?>