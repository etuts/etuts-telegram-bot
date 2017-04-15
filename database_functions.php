<?php 
// get chat state from database
function get_chat_state($text) {
	global $db;
	$state = IDLE; // no state

	if ($db->user_is_new()) {
		$db->insert(0, $text);
	} else {
		$state = $db->get_state();
		$db->update_last_message($text);
	}
	return $state;
}
function handle_state($state, $chat_id, $text, $message_id, $message) {
	global $db;
	switch ($state) {
		case IDLE:
			// user has sent chert o pert! execute help command
			break;
		case CONTACT:
			// user has sent a message to admin! Wow!!
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'یک تماس جدید');
			$db->reset_state();
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			// user has sent title and link of a post to validate
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'مطلب جدید در انتظار بررسی');
			$db->reset_state();
			break;
		case MOAREFI_ROBOT:
			$file = new Posts_file();
			$post_line = $text;
			$file->add_post($post_line);
			break;
	}
}
function add_admin($chat_id) {
	global $db;
	$db->set_permission(ADMIN, $chat_id);
}
