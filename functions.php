<?php

function db_get_state($chat_id) {
	global $db;
	$result = mysqli_query($db, "SELECT `state` FROM `chats` WHERE chat_id = '$chat_id' ");
	return (int)$result->fetch_assoc()['state'];
}
function db_insert($chat_id, $state, $text) {
	global $db;
	mysqli_query($db, "INSERT INTO `chats` (chat_id, state, last_message) VALUES ('$chat_id', '$state', '$text') ");
}
function db_update_last_message($chat_id, $text) {
	global $db;
	mysqli_query($db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$chat_id' ");
}

?>