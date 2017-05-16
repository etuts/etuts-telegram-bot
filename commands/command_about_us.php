<?php

class about_us_command extends base_command {
	public $name = 'about_us';
	public $description = 'درباره سازندگان این ربات';

	
	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		
		$about_us_text = "سازندگان:\n
						وحید محمدی، محمد فغان‌پور گنجی، شهریار سلطان‌پور\n
						ما دانشجوی رشته کامپیوتر دانشگاه تهران هستیم، برای ارتباط با ما می‌تونین از لینک های زیر استفاده کنین.";
		$about_us_reply_markup = create_about_us_keyboard_reply_markup();

		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => $about_us_text,
			'reply_markup' => $about_us_reply_markup,
			]);
	}
}
