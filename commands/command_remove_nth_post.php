<?php 

function run_remove_nth_channel_post_command($chat_id, $text, $message_id, $message, $state) {
	global $db;
	$text = (int) str_replace('/remove_nth_post ', '', $text);
	if (is_int($text) && $text > 0)
		$db->remove_nth_channelpost($text);
	else
		$db->remove_first_channelpost();
	send_thank_message();
}