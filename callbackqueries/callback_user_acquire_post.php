<?php 

function callback_usr_acuir_post($id, $from, $message, $data) {
	global $db, $telegram;

	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	$glassy_text = $message->getText();

	$reserved = $data['r'];

	$db->set_site_recommend_first_post_state($reserved);
	if ($reserved)
		$btn = create_glassy_btn('این مطلب را تهیه میکنم', 'usr_acuir_post', ['r' => RESERVED]);
	else
		$btn = create_glassy_btn('پشیمون شدم! نمیتونم تهیه ش کنم', 'usr_acuir_post', ['r' => NOT_RESERVED]);
	$reply_markup = create_glassy_keyboard([[$btn]]);
	
	// editing the message to remove the buttons.
	$telegram->editMessageText([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'text' => $glassy_text . PHP_EOL . PHP_EOL . emoji('alert') . ' توجه: شما این مطلب را برای نوشتن انتخاب کرده اید',
		'reply_markup' => $reply_markup,
	]);

	$answer_data = ['text' => 'با موفقیت تغییر کرد.'];
	return $answer_data;
}
