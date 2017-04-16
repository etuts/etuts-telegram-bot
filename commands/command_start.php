<?php

function run_start_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید'
	]);
	run_keyboard_buttons($text, $chat_id, $message_id, $message);

	run_help_command($chat_id, $text, $message_id, $message);
}

?>