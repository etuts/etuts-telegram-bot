<?php

function run_schedule_post_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	$answer = 'نوع مطلبی که میخوای بفرستی رو مشخص کن';
	$keyboard = [['معرفی ربات', 'معرفی ابزار']];
	$reply_markup = $telegram->replyKeyboardMarkup([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
		'reply_markup' => $reply_markup
	]);
}
