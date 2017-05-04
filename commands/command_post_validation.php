<?php

function run_post_validation_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case POST_VALIDATION_SEND_POST_TITLE:
			// user has sent title and link of a post to validate
			$btn1 = create_glassy_btn(emoji('like'), 'pst_vldshn', $chat_id, $message_id, '"acc":1');
			$btn2 = create_glassy_btn(emoji('dislike'), 'pst_vldshn', $chat_id, $message_id, '"acc":0');
			$reply_markup = create_glassy_keyboard([[$btn1, $btn2]]);
			send_message_to_admin($message, $text, 'مطلب جدید در انتظار بررسی', $reply_markup);
			$db->reset_state();
			send_thank_message($message_id);
			break;
		
		default:
			$db->set_state(POST_VALIDATION_SEND_POST_TITLE);
			$answer = 'عنوان مطلب و لینک مطلبی که می خواهید بنویسید را وارد کنید';
			$reply_markup = $telegram->forceReply();
			$telegram->sendMessage([
				'chat_id' => $chat_id,
				'text' => $answer,
				'reply_to_message_id' => $message_id,
				'reply_markup' => $reply_markup
			]);

			break;
	}
}

?>