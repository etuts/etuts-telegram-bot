<?php

function run_post_source_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $db;
	switch ($state) {
		case POST_SOURCE:
			$db->add_site_recommend_post($text);
			break;
		
		default:
			reply('لینک مطلب خارجی یا موضوع مطلب رو وارد کنید', true);
			$db->set_state(POST_SOURCE);
			break;
	}
}
