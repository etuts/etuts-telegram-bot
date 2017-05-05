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

function btn_categories($chat_id, $text, $message_id, $message, $state){
	run_categories_command($chat_id, $text, $message_id, $message, $state);
}

function btn_remove_last_channelpost($chat_id, $text, $message_id, $message, $state){
	run_remove_last_channel_post_command($chat_id, $text, $message_id, $message, $state);
}

function btn_post_source($chat_id, $text, $message_id, $message, $state){
	run_post_source_command($chat_id, $text, $message_id, $message, $state);
}

function btn_get_site_recommend_post($chat_id, $text, $message_id, $message, $state){
	run_get_site_recommend_post_command($chat_id, $text, $message_id, $message, $state);
}
