<?php

class aut_val_command extends base_command {
	public $name = 'aut_val';
	public $description = 'درباره سازندگان این ربات';

	
	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		
		$aut_val_text = "سازندگان:\n
						وحید محمدی، محمد فغان‌پور گنجی، شهریار سلطان‌پور\n
						ما دانشجوی رشته کامپیوتر دانشگاه تهران هستیم، برای ارتباط با ما می‌تونین از لینک های زیر استفاده کنین.";
		$aut_val_reply_markup = create_aut_val_keyboard_reply_markup();

		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => $aut_val_text,
			'reply_markup' => $aut_val_reply_markup,
			]);
	}
}
