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

define("POST_SOURCE",10);


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
		case CONTACT:
		case CONTACT_ADMIN_ANSWER:
			$command = new contact_command();
			$func = $command.'->run';
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			$command = new post_validation_command();
			$func = $command.'->run';
			break;
		case MOAREFI_ROBOT_BOT_ID:
		case MOAREFI_ROBOT_BOT_DESCRIPTION:
		case MOAREFI_ROBOT_BOT_IMAGE:
		case MOAREFI_ROBOT_CAPTION:
		case MOAREFI_ROBOT_SCHEDULE_POST:
			$func = 'btn_moarefi_robot';
			break;
		case REQUEST_POST:
			$command = new request_post_command();
			$func = $command.'->run';
			break;
		case POST_SOURCE:
			$command = new post_source_command();
			$func = $command.'->run';
			break;
		case IDLE:
		default:
			return false;
	}
	$func($chat_id, $text, $message_id, $message, $state);
	return true;
}
function add_admin($admin_chat_id) {
	global $db;
	$db->set_permission(ADMIN, $admin_chat_id);
}
