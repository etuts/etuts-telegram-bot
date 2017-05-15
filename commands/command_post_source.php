<?php

class post_source_command extends base_command {
	public $name = 'post_source';
	public $description = 'پیشنهاد دادن مطلبی برای نویسنده ها که در سایت بنویسند';
	public $permission = ADMIN;

	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		switch ($state) {
			case POST_SOURCE:
				$db->add_site_recommend_post($text);
				reset_state(THANK_MESSAGE);
				break;
			
			default:
				reply('لینک مطلب خارجی یا موضوع مطلب رو وارد کنید', true);
				$db->set_state(POST_SOURCE);
				break;
		}
	}
}