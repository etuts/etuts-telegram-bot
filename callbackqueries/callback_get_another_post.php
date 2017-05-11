<?php 

function callback_gt_anthr_post($id, $from, $message, $data) {
	global $db, $telegram;

	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	$glassy_text = $message->getText();

	$post = $db->get_site_recommend_post($data['i']);
	
	// editing the message to remove the buttons.
	$telegram->editMessageText([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'text' => 'مطلب پیشنهاد شده برای نوشتن در سایت:' . PHP_EOL . PHP_EOL . $post,
	]);

	$answer_data = ['text' => 'مطلب جدید'];
	return $answer_data;
}
