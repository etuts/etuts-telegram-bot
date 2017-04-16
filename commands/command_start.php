<?php

function run_start_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید'
	]);
	$keyboard = [['معرفی ربات', 'معرفی ابزار']];
		$reply_markup = $telegram->replyKeyboardMarkup([
			'keyboard' => $keyboard, 
			'resize_keyboard' => true, 
			'one_time_keyboard' => true
		]);

	run_help_command($chat_id, $text, $message_id, $message);
}

?>