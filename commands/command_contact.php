<?php

function run_contact_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case CONTACT:
			// user has sent a message to admin! Wow!!
			send_thank_message($message_id);
			$keyboard = [ [['text' => 'پاسخ', 'callback_data' => '{"func":contact_admin_answer,"chat_id":'.$chat_id.',"message_id":'.$message_id.'}']] ];
			$reply_markup = Telegram\Bot\Keyboard\Keyboard::make([ 'inline_keyboard' => $keyboard, ]);

			send_message_to_admin($message, $text, 'یک تماس جدید', $reply_markup);
			$db->reset_state();
			break;
		
		default:
			$db->set_state(CONTACT);
			$reply_markup = $telegram->forceReply();
			$telegram->sendMessage([
				'chat_id' => $chat_id,
				'text' => 'لطفا پیام تان را بفرستید',
				'reply_to_message_id' => $message_id,
				'reply_markup' => $reply_markup
			]);
			break;
	}
}
