<?php 

function callback_rqst_acc_dny($id, $from, $message, $data) {
	global $db, $telegram;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	
	$db->reset_state();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'مطلب درخواستی شما تایید شده و به زودی در سایت قرار می گیرد',
		'reply_to_message_id' => $message_id,
	]);
	
	$answer_data = ['text' => 'به کاربر اطلاع داده شد که مطلب درخواستی شما در سایت نوشته خواهد دش'];
	sendMessage($answer_data['text'], true);

	return $answer_data;
}
