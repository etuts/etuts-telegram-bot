<?php

function run_request_post_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case REQUEST_POST:
			// user has sent a message to admin! Wow!!
			send_thank_message($message_id);
			send_message_to_admin($message, $text, 'یک درخواست جدید');
			$db->reset_state();
			break;
		
		default:
			$db->set_state(REQUEST_POST);
			$reply_markup = $telegram->forceReply();
			$telegram->sendMessage([
				'chat_id' => $chat_id,
				'text' => 'لطفا عنوان مطلب را وارد کنید.',
				'reply_to_message_id' => $message_id,
				'reply_markup' => $reply_markup
			]);
			break;
	}
}
