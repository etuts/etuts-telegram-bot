<?php 

function callback_admin_answer_to_contact($id, $from, $message, $data) {
	global $db;
	$chat_id = $data['chat_id'];
	$message_id = $data['message_id'];
	$username = $from->getUsername();

	$db->set_state(CONTACT_ADMIN_ANSWER);
	$db->set_data('{"chat_id":' . $chat_id . ',"message_id":' . $message_id . '}');

	sendMessage('در حال پاسخ به ' . $username, true);
}
