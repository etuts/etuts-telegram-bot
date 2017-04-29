<?php

function run_remove_last_channel_post_command($chat_id, $text, $message_id, $message, $state) {
	global $db;
	$db->remove_last_channelpost();
	send_thank_message();
}
