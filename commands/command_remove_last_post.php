<?php

class remove_last_post_command extends base_command {
	public $name = 'remove_last_post';
	public $description = 'پاک کردن آخرین پست زمانبندی شده ی کانال';
	public $permission = ADMIN;
	
	function run($chat_id, $text, $message_id, $message, $state) {
		global $db;
		$db->remove_last_channelpost();
		send_thank_message();
	}
}