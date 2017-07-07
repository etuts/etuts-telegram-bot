<?php 

function callback_set_cm_status($id, $from, $message, $data) {
	global $telegram, $db;
	$id = $data['id'];

	$msg_id = $message->getMessageId();
	$chat_id = $message->getChat()->getId();

	$set_status_url = 'http://etuts.ir/wp-content/plugins/etuts-specific-plugin/scripts/set-comment-status.php';
	$params = [
		'comment_id'=>$comment_id,
	];
	

	$status = $data['status'];
	$reply_markup = '';

	switch ($status) {
		case 'approve':
			$params['comment_status'] = 'approve';
			$answer_button = create_glassy_btn(emoji('message').' پاسخ دهید', 'set_cm_status', ['status'=>'reply']);
			$reply_markup = create_glassy_keyboard([[$answer_button]]);
			break;
		case 'spam':
			$params['comment_status'] = 'spam';
			break;
		case 'trash':
			$params['comment_status'] = 'trash';
			break;
		
		default:
			return;
	}

	$telegram->editMessageReplyMarkup([
		'chat_id' => $admin_chat_id,
		'message_id' => $admin_msg_id,
		'reply_markup' => $reply_markup,
	]);

	send_http_request($set_status_url, 'GET', $params);

	$answer_data = ['text' => ($response === false) ? 'متاسفانه مشکلی پیش آمده' : 'با موفقیت پاک شد'];
	return $answer_data;
}
