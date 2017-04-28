<?php 

function btn_contact($chat_id, $text, $message_id, $message, $state) {
	run_contact_command($chat_id, $text, $message_id, $message, $state);
}

function btn_request_post($chat_id, $text, $message_id, $message, $state) {
	run_request_post_command($chat_id, $text, $message_id, $message, $state);
}

function btn_schedule_post($chat_id, $text, $message_id, $message, $state) {
	run_schedule_post_command($chat_id, $text, $message_id, $message, $state);
}

function btn_post_validation($chat_id, $text, $message_id, $message, $state) {
	run_post_validation_command($chat_id, $text, $message_id, $message, $state);
}
