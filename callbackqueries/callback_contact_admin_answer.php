<?php 

function callback_admn_answr_cntct($id, $from, $message, $data) {
	global $db;
	$chat_id = $data['c'];
	$message_id = $data['m'];
	$fullname = get_fullname($chat_id);

	$db->set_state(CONTACT_ADMIN_ANSWER);
	$db->set_data(["chat_id" => $chat_id, "message_id" => $message_id ]);

	$answer_data = ['text' => 'در حال پاسخ به ' . $fullname];
	sendMessage($answer_data['text'], true);

	return $answer_data;
}
