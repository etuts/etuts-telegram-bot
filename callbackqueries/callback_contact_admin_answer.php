<?php 

function callback_admn_answr_cntct($id, $from, $message, $data) {
	global $db;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	$username = $from->getUsername();

	$db->set_state(CONTACT_ADMIN_ANSWER);
	$db->set_data('{"chat_id":' . $chat_id . ',"message_id":' . $message_id . '}');

	$answer_data = ['text' => 'در حال پاسخ به ' . $username];
	sendMessage($answer_data['text'], true);

	return $answer_data;
}
