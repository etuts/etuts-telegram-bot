<?php

function remove_last_channel_post($chat_id, $text, $message_id, $message, $state) {
	$db->remove_last_channelpost();
	send_thank_message();
}
