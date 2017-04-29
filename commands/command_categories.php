<?php 

	function run_categories_command($chat_id, $text, $message_id, $message, $state){
		global $telegram, $db;

		// $checked = db->get_categories_checked_array(); // this must be taken from database to see if it is checked or not.
		// temp:

		$checked = $db->get_categories_checked_array();
		log_debug(var_export($checked, true), 117990761);
		
		$reply_markup = create_categories_keyboard_reply_markup($checked, $chat_id, $message_id);
			
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => 'دسته بندی هایی که می‌خواهید مطالبشان برایتان ارسال شود را انتخاب کنید.',
			'reply_markup' => $reply_markup,
		]);


	}	

?>