<?php

// connect to database
$db = mysqli_connect('localhost','ZMYbZ5jIaqW5SYi','bzJcaSbjlgtp9K9','etutsTeleRobot') or die('Error connecting to MySQL server.');

// requirements
require 'vendor/autoload.php';
require 'functions.php'
use Telegram\Bot\Api;

// connecting
$telegram = new Api('291144367:AAF66QzZVlw8MH0c8RyCD9hmnYnzRRrqMWs');

// get user message
$updates = $telegram->getWebhookUpdates();
$chat_id = (int) $updates->getMessage()->getChat()->getId();
$text = $updates->getMessage()->getText();
$telegram->addCommand(Commands\ContactCommand::class);

// Enum of STATEs
class User_state extends SplEnum {
    const __default = self::Cancel;
    
    const Cancel = 0;
    const Contact = 1;
}

// get chat state from database
$result = mysqli_query($db, "SELECT * FROM `chats` WHERE chat_id = '$chat_id' ");
$state = new User_state(User_state::Cancel); // no state

if( mysqli_num_rows($result) == 0) {
    db_insert($chat_id, 0, $text);
}
else {
	$state = db_get_state($chat_id);
	db_update_last_message($chat_id, $text);
}

// switch case

$telegram->sendMessage([
  'chat_id' => $chat_id,
  'text' => $state
]);

// close database
mysqli_close($db);

?>