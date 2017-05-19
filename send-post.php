#!/usr/bin/php
<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/database_class.php';

try {
	$db = new Database($db_name, $db_user, $db_pass);
	$telegram = new Api($token);

	$post_data = $db->read_channelpost();
	if ($post_data === false)
		die("no posts");

	$type = $post_data['type'];

	if ($type == '')
		die("no type");

	switch ($type) {
		case 'text':
			$telegram->sendMessage([
				'chat_id' => $channel_id,
				'text' => $post_data['text'],
			]);
			break;
		case 'photo':
			$telegram->sendPhoto([
				'chat_id' => $channel_id,
				'photo' => $post_data['photo'],
				'caption' => $post_data['caption'],
			]);
			break;
	}
	$num_of_posts_left = $db->get_num_of_channelposts_left();
	$telegram->sendMessage([
		'chat_id' => $admin_id,
		'text' => 'تنها ' . $num_of_posts_left . ' مطلب برای ارسال در کانال باقی مانده.',
	]);
} catch (Exception $e) {
	$telegram->sendMessage([
		'chat_id' => $admin_id,
		'text' => $e->getPrevious(),
	]);
}