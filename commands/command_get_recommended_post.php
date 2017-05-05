<?php

function run_get_recommended_post_command($chat_id, $text, $message_id, $message, $state) {
	global $db, $telegram;
	$post = $db->get_site_recommend_post();
	if ($post === false) {
		reply('هیچ مطلبی برای پیشنهاد وجود ندارد');
		send_message_to_admin('هیچ مطلبی برای پیشنهاد وجود ندارد');
		return;
	}
	$btn = create_glassy_btn('این مطلب را تهیه میکنم', 'usr_acuir_post');
	$reply_markup = create_glassy_keyboard([[$btn]]);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'مطلب پیشنهاد شده برای نوشتن در سایت:' . PHP_EOL . PHP_EOL . $post,
		'reply_markup' => $reply_markup
	]);
}
