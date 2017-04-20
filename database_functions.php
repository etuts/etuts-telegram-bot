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
	switch ($state) {
		case IDLE:
			// user has sent chert o pert! execute help command
			break;
		case CONTACT:
			run_contact_command($chat_id, $text, $message_id, $message, CONTACT);
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			run_post_validation_command($chat_id, $text, $message_id, $message, POST_VALIDATION_SEND_POST_TITLE);
			break;
		case MOAREFI_ROBOT:
			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT);
			break;
	}
}
function add_admin($admin_chat_id) {
	global $db;
	$db->set_permission(ADMIN, $admin_chat_id);
}
