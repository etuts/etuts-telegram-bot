<?php 

class manage_channel_posts_command extends base_command {
	public $name = 'manage_channel_posts';
	public $description = 'مدیریت پست های زمانبندی شده برای کانال';
	public $permission = ADMIN;

	function run($chat_id, $text, $message_id, $message, $state) {
		global $db, $telegram;
		$channelposts = $db->get_channelposts();
		if (count($channelposts) == 0) {
			reply('هیچ مطلبی در دیتابیس وجود ندارد!');
			return;
		}
		
		$btns = array();
		foreach ($channelposts as $post) {
			$data = $post['data'];
			$data = json_decode($data, true);
			$btns[] = [create_glassy_btn($data['text'], 'rmv_chnlpost', ['id' => $post['id']])];
		}
		
		$keyboard = $btns;
		$reply_markup = create_glassy_keyboard($keyboard);
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => 'در اینجا لیست تمام مطالبی که برای ارسال در کانال زمان بندی شده اند را مشاهده می کنید. شما با انتخاب هر کدام از این مطالب، آن را از دیتابیس حذف خواهید کرد',
			'reply_markup' => $reply_markup,
		]);
	}
}