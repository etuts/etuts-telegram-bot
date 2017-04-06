<?php

// database functions 
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

// telegram bot api functions
function send_message_to_admin($text) {
	global $telegram;
	$telegram->sendMessage([
	  'chat_id' => 92454,
	  'text' => $text
	]);
}

?>