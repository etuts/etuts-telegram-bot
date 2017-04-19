<?php


function run_contact_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	$db->set_state(CONTACT);
	$reply_markup = $telegram->forceReply();
	reply('لطفا پیام تان را بفرستید', $message_id, true);
}

?>