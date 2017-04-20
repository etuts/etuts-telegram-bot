<?php

function run_cancel_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	$db->reset_state();
	$reply_markup = $telegram->replyKeyboardHide();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'عملیات با موفقیت کنسل شد',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
