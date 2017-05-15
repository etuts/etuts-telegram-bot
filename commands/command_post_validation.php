<?php

class post_validation_command extends base_command {
	public $name = 'manage_channel_posts';
	public $description = 'نویسنده های سایت می توانند مطلبی که می خواهند بنویسند را از این طریق به ادمین اطلاع دهند تا ادمین تایید کند';
	public $permission = AUTHOR;

	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		switch ($state) {
			case POST_VALIDATION_SEND_POST_TITLE:
				// user has sent title and link of a post to validate
				$btn1 = create_glassy_btn(emoji('like'), 'pst_vldshn', ['c' => $chat_id, 'm' => $message_id, 'acc' => 1]);
				$btn2 = create_glassy_btn(emoji('dislike'), 'pst_vldshn', ['c' => $chat_id, 'm' => $message_id, 'acc' => 0]);
				$reply_markup = create_glassy_keyboard([[$btn1, $btn2]]);
				send_message_to_admin(create_report_from_a_user_message('مطلب جدید در انتظار بررسی', $text), $reply_markup);
				reset_state(THANK_MESSAGE);
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
}