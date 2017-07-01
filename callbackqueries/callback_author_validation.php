<?php 

function callback_aut_val($id, $from, $message, $data) {
	global $db, $telegram;

	$accept = $data['acc'];
	$chat_id = $data['c'];
	$username = $data['usr'];
	
	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();

	if ($accept == 1) {
		$db->set_etuts_user($username, $chat_id);
		$db->set_permission(AUTHOR, $chat_id);
		$author_reply_text = 'درخواست شما برای تایید نویسندگی تایید شد. شما توسط مدیر سایت، به عنوان نویسنده ی سایت در این ربات ثبت شدید.';
	} else {
		$author_reply_text = 'درخواست شما برای تایید نویسندگی رد شد.';
	}
	
	// send message to author
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $user_reply_text,
	]);

	// editing inline buttons.
	$telegram->editMessageReplyMarkup([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'reply_markup' => '',
	]);

	// admin callback answer
	$answer_data = ['text' => 'با موفقیت انجام شد.'];
	return $answer_data;
}
