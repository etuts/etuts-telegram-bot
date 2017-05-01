<?php 

//--------------------- Enum of STATEs ---------------------------
define("IDLE", 0);

define("CONTACT", 1);
define("CONTACT_ADMIN_ANSWER", 2);

define("POST_VALIDATION_SEND_POST_TITLE", 3);

define("MOAREFI_ROBOT_BOT_ID", 4);
define("MOAREFI_ROBOT_BOT_DESCRIPTION", 5);
define("MOAREFI_ROBOT_BOT_IMAGE", 6);
define("MOAREFI_ROBOT_CAPTION", 7);
define("MOAREFI_ROBOT_SCHEDULE_POST", 8);

define("REQUEST_POST",9);


// get chat state from database
function get_chat_state($text, $username, $fullname) {
	global $db;
	$state = IDLE; // no state

	if ($db->user_is_new()) {
		$db->insert(0, $text, $username, $fullname);
	} else {
		$state = $db->get_state();
		$db->set_last_message($text);
		$db->set_username($username);
		$db->set_fullname($fullname);
	}
	return $state;
}
function handle_state($state, $chat_id, $text, $message_id, $message) {
	switch ($state) {
		case IDLE:
			return false;
		case CONTACT:
			run_contact_command($chat_id, $text, $message_id, $message, CONTACT);
			break;
		case CONTACT_ADMIN_ANSWER:
			run_contact_command($chat_id, $text, $message_id, $message, CONTACT_ADMIN_ANSWER);
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			run_post_validation_command($chat_id, $text, $message_id, $message, POST_VALIDATION_SEND_POST_TITLE);
			break;
		case MOAREFI_ROBOT_BOT_ID:
			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT_BOT_ID);
			break;
		case MOAREFI_ROBOT_BOT_DESCRIPTION:
			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT_BOT_DESCRIPTION);
			break;
		case MOAREFI_ROBOT_BOT_IMAGE:
			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT_BOT_IMAGE);
			break;
		case MOAREFI_ROBOT_SCHEDULE_POST:
			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT_SCHEDULE_POST);
			break;
		case REQUEST_POST:
			run_request_post_command($chat_id, $text, $message_id, $message,REQUEST_POST);
			break;
		default:
			return false;
	}
	return true;
}
function add_admin($admin_chat_id) {
	global $db;
	$db->set_permission(ADMIN, $admin_chat_id);
}
