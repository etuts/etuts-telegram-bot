#!/usr/bin/php
<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/database_class.php';

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
		$message = $telegram->sendPhoto([
			'chat_id' => $channel_id,
			'photo' => $post_data['photo'],
			'caption' => $post_data['caption'],
		]);
		break;
}
