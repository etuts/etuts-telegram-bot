<?php

function run_contact_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case CONTACT:
			// user has sent a message to admin! Wow!!
			send_thank_message($message_id);
			
			$btn1 = ['text' => '7', 'callback_data' => '{"f":admn_answr_cntct,"c":'.(string)$chat_id.',"m":'.(string)$message_id.'}'];
		    $keyboard = [ [$btn1] ];
		    $reply_markup = Telegram\Bot\Keyboard\Keyboard::make([ 'inline_keyboard' => $keyboard, ]);

			log_debug("ok");

			send_message_to_admin($message, $text, 'یک تماس جدید', $reply_markup);
			$db->reset_state();
			break;
		
		case CONTACT_ADMIN_ANSWER:
			// this the answer of admin to the user who has sent it
			$data = json_decode($db->get_data());
			$dest_chat_id = $data['chat_id'];
			$dest_message_id = $data['message_id'];
			$telegram->sendMessage([
				'chat_id' => $dest_chat_id,
				'text' => $text,
				'reply_to_message_id' => $dest_message_id,
			]);
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
