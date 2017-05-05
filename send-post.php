#!/usr/bin/php
<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/database_class.php';

try {
	$db = new Database($db_name, $db_user, $db_pass);
	$telegram = new Api($token);

	$post_data = $db->read_post();
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
	$num_of_posts_left = $db->get_num_of_posts_left();
	$telegram->sendMessage([
		'chat_id' => $admin_id,
		'text' => 'تنها' . var_export($num_of_posts_left, true) . 'برای ارسال در کانال باقی مانده.',
	]);
	$telegram->sendMessage([
		'chat_id' => 92454,
		'text' => 'تنها' . $num_of_posts_left . 'برای ارسال در کانال باقی مانده.',
	]);
} catch (Exception $e) {
	log_debug($e->getPrevious());
}