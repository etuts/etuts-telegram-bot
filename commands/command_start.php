<?php

function run_start_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram;

	$reply_markup = get_initial_keyboard();

	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید',
		'reply_markup' => $reply_markup
	]);

	run_keyboard_button();
}
