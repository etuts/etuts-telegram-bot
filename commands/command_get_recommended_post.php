<?php

function run_get_recommended_post_command($chat_id, $text, $message_id, $message, $state) {
	global $db;
	$post = $db->get_site_recommend_post();
	$btn = create_glassy_btn('این مطلب را تهیه میکنم', 'usr_acuir_post');
	$reply_markup = create_glassy_keyboard([[$btn]]);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'مطلب پیشنهاد شده برای نوشتن در سایت:' . PHP_EOL . PHP_EOL . $post,
		'reply_markup' => $reply_markup
	]);
}
