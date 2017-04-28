<?php 

function callback_rqst_acc_dny($id, $from, $message, $data) {
	global $db, $telegram;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	$accepted = $data['acc'];
	
	$admin_msg_id = $message->getMessageId();
	$admin_chat_id = $message->getChatId();
	log_debug($admin_msg_id, 117990761);
	log_debug($admin_chat_id, 117990761);
	
	$user_answer;
	$admin_answer;

	if ($accepted == 1) {
		$user_answer = 'مطلب درخواستی شما تایید شده و به زودی در سایت قرار می گیرد';
		$admin_answer = 'تایید شد';
	} else {
		$user_answer = 'مطلب درخواستی شما تایید نشد';
		$admin_answer = 'رد شد';
	}
	// editing the message to remove the buttons.
	$telegram->editMessageReplyMarkup([
		'chat_id' => $admin_chat_id,
		'message_id' => $admin_msg_id,
		'reply_markup' => '',
	]);

	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $user_answer,
		'reply_to_message_id' => $message_id,
	]);
	
	$answer_data = ['text' => $admin_answer];
	
	$db->reset_state();

	return $answer_data;
}
