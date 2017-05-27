<?php 

//--------------------- Enum of STATEs ---------------------------
define("IDLE", 0);

define("CONTACT", 1);
define("CONTACT_ADMIN_ANSWER", 2);

define("POST_VALIDATION_SEND_POST_TITLE", 3);

define("MOAREFI_ROBOT_BOT_ID", 4);
define("MOAREFI_ROBOT_BOT_TITLE", 5);
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
	$func = $class = '';
	switch ($state) {
		case CONTACT:
		case CONTACT_ADMIN_ANSWER:
			$class = 'contact_command';
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			$class = 'post_validation_command';
			break;
		case MOAREFI_ROBOT_BOT_ID:
		case MOAREFI_ROBOT_BOT_TITLE:
		case MOAREFI_ROBOT_BOT_IMAGE:
		case MOAREFI_ROBOT_CAPTION:
		case MOAREFI_ROBOT_SCHEDULE_POST:
			$func = 'btn_moarefi_robot';
			break;
		case REQUEST_POST:
			$class = 'request_post_command';
			break;
		case POST_SOURCE:
			$class = 'post_source_command';
			break;
		case IDLE:
		default:
			return false;
	}
	if (class_exists($class)) {
		$command = new $class();
		$command->run($chat_id, $text, $message_id, $message, $state);
	} else if ($func !== '') {
		$func($chat_id, $text, $message_id, $message, $state);
	}
	
	return true;
}
function add_admin($admin_chat_id) {
	global $db;
	$db->set_permission(ADMIN, $admin_chat_id);
}
