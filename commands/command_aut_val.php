<?php

class aut_val_command extends base_command {
	public $name = 'aut_val';
	public $description = 'درباره سازندگان این ربات';

	
	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		switch ($state) {
			case AUTHOR_VALIDATION:
				reply(THANK_MESSAGE);
				send_message_to_admin("یه نفر ادا کرده نویسنده ی سایته:\n". "یوزرنیمش: ".$text);
				break;
			default:
				$aut_val_text = "این دستور برای تایید شما به عنوان نویسنده ی سایت هست\n
								لطفا یوزرنیم تون در سایت etuts.ir رو بنویسید.\n
								بعد منتظر باشید تا مدیر سایت شما رو تایید کند.";
				$db->set_state(AUTHOR_VALIDATION);
				$telegram->sendMessage([
					'chat_id' => $chat_id,
					'text' => $aut_val_text,
				]);
				break;
		}
	}
}
