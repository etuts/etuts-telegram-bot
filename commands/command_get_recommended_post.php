<?php

class get_recommended_post_command extends base_command {
	public $name = 'get_recommended_post';
	public $description = 'یک مطلب برای نوشتن در سایت به شما پیشنهاد می دهد';
	public $permission = AUTHOR;

	function run($chat_id, $text, $message_id, $message, $state) {
		global $db, $telegram;
		$row = $db->get_site_recommend_post();
		if ($row === false) {
			reply('هیچ مطلبی برای پیشنهاد وجود ندارد');
			send_message_to_admin('هیچ مطلبی برای پیشنهاد وجود ندارد');
			return;
		}
		$post = $row['post'];
		$id = $row['id'];
		$btn = create_glassy_btn('این مطلب را تهیه میکنم', 'usr_acuir_post', ['r' => RESERVED, 'i' => $id]);
		$btn2 = create_glassy_btn('یک مطلب دیگه پیشنهاد بده', 'gt_anthr_post', ['i' => $id]);
		$reply_markup = create_glassy_keyboard([[$btn], [$btn2]]);
		$telegram->sendMessage([
			'chat_id' => $chat_id,
			'text' => 'مطلب پیشنهاد شده برای نوشتن در سایت:' . PHP_EOL . PHP_EOL . $post,
			'reply_markup' => $reply_markup
		]);
	}
}