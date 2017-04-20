<?php

function run_post_validation_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case POST_VALIDATION_SEND_POST_TITLE:
			// user has sent title and link of a post to validate
			send_thank_message($message_id);
			send_message_to_admin($message, $text, 'مطلب جدید در انتظار بررسی');
			$db->reset_state();
			break;
		
		default:
			if ($db->check_user_permission(AUTHOR) || $db->check_user_permission(ADMIN)) {
				$db->set_state(POST_VALIDATION_SEND_POST_TITLE);
				$answer = 'عنوان مطلب و لینک مطلبی که می خواهید بنویسید را وارد کنید';
				$reply_markup = $telegram->forceReply();
			} else {
				$answer = 'ببخشید اما شما نویسنده ی سایت نیستید!';
			}
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