<?php 

function callback_pst_vldshn($id, $from, $message, $data) {
	global $telegram;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	$accepted = $data['acc'];
		
	$admin_msg_id = $message->getMessageId();
	$admin_chat_id = $message->getChat()->getId();
	
	$user_answer;
	$admin_answer;

	if ($accepted == 1) {
		$user_answer = 'مطلب شما تایید شد. لطفا آن را در سایت بنویسید';
		$admin_answer = 'تایید شد';
	} else {
		$user_answer = 'متاسفانه مطلب شما تایید نشد';
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
	
	return $answer_data;
}
