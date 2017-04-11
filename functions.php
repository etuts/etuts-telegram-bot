<?php

require_once 'config.php';

//--------------------- Enum of STATEs ----------------------
define("CANCEL", 0);
define("CONTACT", 1);

//--------------------- database functions ------------------
function db_get_user_row($chat_id) {
	global $db;
	return mysqli_query($db, "SELECT * FROM `chats` WHERE chat_id = '$chat_id' ");
}
function db_get_state($chat_id) {
	global $db;
	$result = mysqli_query($db, "SELECT `state` FROM `chats` WHERE chat_id = '$chat_id' ");
	return (int)$result->fetch_assoc()['state'];
}
function db_insert($chat_id, $state, $text) {
	global $db;
	return mysqli_query($db, "INSERT INTO `chats` (chat_id, state, last_message) VALUES ('$chat_id', '$state', '$text') ");
}
function db_update_last_message($chat_id, $text) {
	global $db;
	return mysqli_query($db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$chat_id' ");
}
function db_set_state($chat_id, $state) {
	global $db;
	return mysqli_query($db, "UPDATE `chats` SET state = '$state' WHERE chat_id = '$chat_id' ");
}
function db_reset_state($chat_id) {
	return db_set_state($chat_id,0);
}

// get chat state from database
function get_chat_state($chat_id) {
	$result = db_get_user_row($chat_id);
	$state = CANCEL; // no state
	if( mysqli_num_rows($result) == 0) {
	    db_insert($chat_id, 0, $text);
	}
	else {
		$state = db_get_state($chat_id);
		db_update_last_message($chat_id, $text);
	}
	return $state;
}

//--------------------- telegram bot api functions ---------------
$available_commands = ['/contact'];

function run_commands($text, $chat_id, $message_id) {
	global $available_commands;
	$commands_index = get_command($text);
	foreach ($commands_index as $command_index) {
		$func = 'run_' . ltrim($available_commands[$command_index], '/') . '_command';
		$func($chat_id, $text, $message_id);
	}
}
function get_command($text) {
	global $available_commands;
	$contain_these_commands = array();
	foreach ($available_commands as $index=>$command) {
		if (contains_word($text, $command))
			$contain_these_commands[] = $index;
	}
	return $contain_these_commands;
}

//--------------------- telegram bot command functions -------------
function run_contact_command($chat_id, $text, $message_id) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'لطفا پیام تان را بفرستید',
		'reply_to_message_id' => $message_id
	]);
	db_set_state($chat_id, CONTACT);
}

//--------------------- telegram bot api helper functions ---------
function send_message_to_admin($message, $text) {
	global $telegram;
	$username = $message->getFrom()->getUsername();
	$firstname = $message->getFrom()->getFirstname();
	$lastname = $message->getFrom()->getLastname();
	$text = 'name: ' . $firstname . ' ' . $lastname . "\r\n" . 'from: @' . $username . "\r\n" . 'text: ' . $text;

	/*$inline_keyboard_button = [
		'text' => 'hi'
	];
	$inline_keyboard_buttons = array();
	$inline_keyboard_buttons[] = $inline_keyboard_button;

	$reply_markup = $telegram->inlineKeyboardMarkup([
		'inline_keyboard' => $inline_keyboard_buttons
	]);*/

	$keyboard = [
	    ['7', '8', '9'],
	    ['4', '5', '6'],
	    ['1', '2', '3'],
	         ['0']
	];
/*	$reply_markup = $telegram->replyKeyboardMarkup([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);*/

	$keyboard = Telegram\Bot\Keyboard\Keyboard::make([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);
	// $keyboard->inline();
	// $reply_markup->inline();

	$telegram->sendMessage([
	  'chat_id' => 92454,
	  'text' => $text,
	  // 'reply_markup' => $reply_markup
	]);
}
function send_thank_message($chat_id, $message_id) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خیلی ممنون! با موفقیت انجام شد.',
		'reply_to_message_id' => $message_id
	]);
}

//--------------------- helpers -------------------------------
function contains_word($source, $find) {
	if (strpos($source, $find) !== false)
		return true;
	return false;
}
function log_debug($text) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => 92454,
		'text' => $text
	]);
	$debug_file = fopen("log.txt","a");
	fwrite($debug_file, "-------------------------\r\n" . $text . "\r\n");
	fclose($file);
}

?>