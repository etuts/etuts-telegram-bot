<?php 
	$categories_array = [
		'game'=>'بازی', 
		'electricity'=>'برق', 
		'desktop'=>'دسکتاپ', 
		'design'=>'طراحی', 
		'mobile'=>'موبایل', 
		'web'=>'وب'
	];
	$lots_of_dots = '...........................................................';

	function run_categories_command($chat_id, $text, $message_id, $message, $state){
		global $telegram, $db, $categories_array;

		$btns = [];
		foreach($categories_array as $category => $name){
			$checked = 0; // this must be taken from database to see if it is checked or not.
			$txt = emoji($checked ? 'checked':'not_checked') . '. ' . emoji($category) . ' ' . $name . $lots_of_dots;
			$btns[] = create_glassy_btn($txt , 'check', $chat_id, $message_id, '"c":'.$checked);
		}
		$reply_markup = create_glassy_keyboard([$btns]);

		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => $answer,
			'reply_markup' => $reply_markup,
		]);

	}	

?>