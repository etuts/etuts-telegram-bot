<?php

class schedule_post_command extends base_command {
	public $name = 'schedule_post';
	public $description = 'زمانبندی مطلب برای ارسال در کانال';
	public $permission = ADMIN;

	function run($chat_id, $text, $message_id, $message, $state) {
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
}