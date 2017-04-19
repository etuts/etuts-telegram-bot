<?php

function run_contact_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	$db->set_state(CONTACT);
	$reply_markup = $telegram->forceReply();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'لطفا پیام تان را بفرستید',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
