<?php 

class categories_command extends base_command {
	public $name = 'categories';
	public $description = 'انتخاب دسته بندی ها برای دریافت آخرین مطالب سایت';

	function run($chat_id, $text, $message_id, $message, $state){
		global $telegram, $db;

		$checked = $db->get_categories_checked_array();

		$reply_markup = create_categories_keyboard_reply_markup($checked);
			
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => "دسته بندی هایی که می‌خواهید مطالبشان برایتان ارسال شود را انتخاب کنید.\n پست های جدید مربوط به دسته های انتخاب شده از طریق ربات برای شما ارسال می‌گردد.",
			'reply_markup' => $reply_markup,
		]);
	}
}
