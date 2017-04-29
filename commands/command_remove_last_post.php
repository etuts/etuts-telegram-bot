<?php

function run_command_remove_last_post($chat_id, $text, $message_id, $message, $state) {
	$db->remove_last_channelpost();
	send_thank_message();
}
