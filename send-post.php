#!/usr/bin/php
<?php 
/*
open a file that contains posts. each post on a line
send the post to channel (you may be able to require the codes of iraqsaqi (bayad beshe dige moshkeli nadare))
delete that line
*/

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/posts_file_class.php';

$file = new Posts_file(false);

if ($file) {
	$telegram = new Api($token);

	$post_data = $file->read_post();
	$type = $post_data['type'];
	if ($type == '')
		die();
	switch ($type) {
		case 'text':
			$telegram->sendMessage([
				'chat_id' => $post_data['chat_id'],
				'text' => utf8_decode($post_data['text']),
			]);
			break;
		case 'photo':
			$telegram->sendPhoto([
				'chat_id' => $post_data['chat_id'],
				'photo' => $post_data['photo'],
				'caption' => utf8_decode($post_data['caption']),
			]);
			break;
	}
} else
	echo 'failed' . PHP_EOL;

