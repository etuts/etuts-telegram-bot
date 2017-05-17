<?php

class request_post_command extends base_command {
	public $name = 'request_post';
	public $description = 'درخواست مطلب آموزشی - اگر آموزشی لازم دارید به ما اطلاع دهید';
	
	function run($chat_id, $text, $message_id, $message, $state) {
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
				reply("در این قسمت شما می توانید مطلبی درخواست کنید تا ما آن را در سایت تهیه کنیم.\n\n
								برای لغو این عملیات، دستور /cancel را انتخاب کنید.", true);
				break;
		}
	}
}