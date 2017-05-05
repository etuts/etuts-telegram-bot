<?php

function run_request_post_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case REQUEST_POST:
			// user has sent a message to admin! Wow!!
			$btn1 = create_glassy_btn(emoji('like'), 'rqst_acc_dny', ['c' => $chat_id, 'm' => $message_id, 'acc' => 1]);
			$btn2 = create_glassy_btn(emoji('dislike'), 'rqst_acc_dny', ['c' => $chat_id, 'm' => $message_id, 'acc' => 0]);
			$reply_markup = create_glassy_keyboard([[$btn1, $btn2]]);
			send_message_to_admin(create_report_from_a_user_message('یک درخواست جدید', $text), $reply_markup);
			reset_state(THANK_MESSAGE);
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
