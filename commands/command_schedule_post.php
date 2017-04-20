<?php

function run_schedule_post_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	if ($db->check_user_permission(ADMIN)) {
		$answer = 'نوع مطلبی که میخوای بفرستی رو مشخص کن' . PHP_EOL;
		$keyboard = [['معرفی ربات', 'معرفی ابزار']];
		$reply_markup = $telegram->replyKeyboardMarkup([
			'keyboard' => $keyboard, 
			'resize_keyboard' => true, 
			'one_time_keyboard' => true
		]);
	} else {
		$answer = 'برای استفاده از این دستور باید ادمین کانال باشید';
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
		'reply_markup' => $reply_markup
	]);
}
