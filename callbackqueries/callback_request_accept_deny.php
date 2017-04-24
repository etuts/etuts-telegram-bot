<?php 

function callback_rqst_acc_dny($id, $from, $message, $data) {
	global $db, $telegram;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	$accepted = $data['acc'];
	
	$user_answer;
	$admin_answer;

	if ($accepted == 1) {
		$user_answer = 'مطلب درخواستی شما تایید شده و به زودی در سایت قرار می گیرد';
		$admin_answer = 'تایید شد';
	} else {
		$user_answer = 'مطلب درخواستی شما تایید نشد';
		$admin_answer = 'رد شد';
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $user_answer,
		'reply_to_message_id' => $message_id,
	]);
	
	$answer_data = ['text' => $admin_answer];
	
	$db->reset_state();

	return $answer_data;
}
