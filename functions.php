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

function send_message_to_admin($message, $text) {
	global $telegram;
	$telegram->sendMessage([
	  'chat_id' => 92454,
	  'text' => $text . $message->getFrom()->getUsername()
	]);
}
function get_command($text) {
	global $available_commands;
	$contain_these_commands = array();
	foreach ($available_commands as $command) {
		if (contains_word($text, $command))
			$contain_these_commands[] = $command;
	}
	return $contain_these_commands;
}
function run_command($command, $chat_id, $text, $message_id) {
	global $telegram;
	switch ($command) {
		case '/contact':
			$telegram->sendMessage([
				'chat_id' => $chat_id,
				'text' => 'لطفا پیام بفرستید',
				'reply_to_message_id' => $message_id
			]);
			db_set_state($chat_id, CONTACT);
			break;
	}
}

//--------------------- helpers -------------------------------
function contains_word($source, $find) {
	if (strpos($source, $find) !== false)
		return true;
	return false;
}
function log_debug($text) {
	$debug_file = fopen("log.txt","a");
	fwrite($debug_file, $text);
	fclose($file);
}

?>