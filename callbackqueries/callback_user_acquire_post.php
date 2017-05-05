<?php 

function callback_usr_acuir_post($id, $from, $message, $data) {
	global $db, $telegram;

	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	$glassy_text = $message->getText();

	$db->set_site_recommend_first_post_state(RESERVED);
	
	// editing the message to remove the buttons.
	$telegram->editMessageText([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'text' => $glassy_text . PHP_EOL . PHP_EOL . emoji('alert') . ' توجه: شما این مطلب را برای نوشتن انتخاب کرده اید',
	]);

	$answer_data = ['text' => 'با موفقیت تغییر کرد.'];
	return $answer_data;
}
