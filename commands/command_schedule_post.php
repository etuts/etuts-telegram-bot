<?php

function run_schedule_post_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram;
	$keyboard = [['معرفی ربات', 'معرفی ابزار']];
	$reply_markup = $telegram->replyKeyboardMarkup([
		'keyboard' => $keyboard,
		'resize_keyboard' => true,
		'one_time_keyboard' => true
	]);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'نوع مطلبی که میخوای بفرستی رو مشخص کن',
		'reply_markup' => $reply_markup
	]);
}
