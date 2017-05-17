<?php 

function btn_about_us($chat_id, $text, $message_id, $message, $state) {
	$command = new about_us_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_contact($chat_id, $text, $message_id, $message, $state) {
	$command = new contact_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_request_post($chat_id, $text, $message_id, $message, $state) {
	$command = new request_post_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_schedule_post($chat_id, $text, $message_id, $message, $state) {
	$command = new schedule_post_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_post_validation($chat_id, $text, $message_id, $message, $state) {
	$command = new post_validation_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_categories($chat_id, $text, $message_id, $message, $state){
	$command = new categories_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_remove_last_channelpost($chat_id, $text, $message_id, $message, $state){
	$command = new remove_last_channel_post_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_post_source($chat_id, $text, $message_id, $message, $state){
	$command = new post_source_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_get_site_recommend_post($chat_id, $text, $message_id, $message, $state){
	$command = new get_recommended_post_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}

function btn_manage_channel_posts($chat_id, $text, $message_id, $message, $state){
	$command = new manage_channel_posts_command();
	$command->run($chat_id, $text, $message_id, $message, $state);
}
