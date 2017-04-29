<?php 
	$categories_array = [
		['emoji'=>'game', 'name'=>'بازی'], 
		['emoji'=>'electricity', 'name'=>'برق'], 
		['emoji'=>'desktop', 'name'=>'دسکتاپ'], 
		['emoji'=>'design', 'name'=>'طراحی'], 
		['emoji'=>'mobile', 'name'=>'موبایل'], 
		['emoji'=>'web', 'name'=>'وب'], 
	];
	$lots_of_dots = str_repeat('.', 100);

	function run_categories_command($chat_id, $text, $message_id, $message, $state){
		global $telegram, $db, $categories_array, $lots_of_dots;

		// $checked = db->get_categories_checked_array(); // this must be taken from database to see if it is checked or not.
		// temp:
		$checked = [0, 0, 0, 0, 0, 0];
			
		$reply_markup = create_categories_keyboard_reply_markup($checked);
			
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => 'دسته بندی هایی که می‌خواهید مطالبشان برایتان ارسال شود را انتخاب کنید.',
			'reply_markup' => $reply_markup,
		]);

	}	

?>