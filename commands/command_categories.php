<?php 

	function run_categories_command($chat_id, $text, $message_id, $message, $state){
		global $telegram, $db;

		// $checked = db->get_categories_checked_array(); // this must be taken from database to see if it is checked or not.
		// temp:
		log_debug("0_0", 117990761);

		$checked = [0, 0, 0, 0, 0, 0];
		log_debug("0_1", 117990761);
		
		$reply_markup = create_categories_keyboard_reply_markup($checked);
		log_debug("0_2", 117990761);
			
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => 'دسته بندی هایی که می‌خواهید مطالبشان برایتان ارسال شود را انتخاب کنید.',
			'reply_markup' => $reply_markup,
		]);
		

	}	

?>