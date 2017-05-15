<?php

class cancel_command extends base_command {
	public $name = 'cancel';
	public $description = 'لغو هر عملیاتی که در حال انجام آن هستید';

	function run($chat_id, $text, $message_id, $message, $state) {
		global $telegram, $db;
		reset_state('عملیات با موفقیت کنسل شد');
	}
}
