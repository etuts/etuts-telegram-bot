<?php 

function callback_gt_anthr_post($id, $from, $message, $data) {
	global $db, $telegram;

	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	$glassy_text = $message->getText();

	$new_index = $data['i']+1;
	$post = $db->get_site_recommend_post($new_index-1);
	$btn = create_glassy_btn('این مطلب را تهیه میکنم', 'usr_acuir_post', ['r' => RESERVED]);
	$btn2 = create_glassy_btn('یک مطلب دیگه پیشنهاد بده', 'gt_anthr_post', ['i' => $new_index]);
	$reply_markup = create_glassy_keyboard([[$btn], [$btn2]]);
	
	// editing the message to remove the buttons.
	$telegram->editMessageText([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'text' => 'مطلب پیشنهاد شده برای نوشتن در سایت:' . PHP_EOL . PHP_EOL . $post,
		'reply_markup' => $reply_markup,
	]);

	$answer_data = ['text' => 'مطلب جدید' . $new_index];
	return $answer_data;
}
