#!/usr/bin/php
<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/database_class.php';

try {
	$telegram = new Api($token);
	if (empty($_POST) || !isset($_POST['text']) || !isset($_POST['image_link']))
		die;

	$title = $_POST['title'];
	$content = $_POST['content'];
	$image_link = $_POST['image_link'];
	$bot_id = $_POST['bot_id'];

	$text = $title . "\n\n" . $bot_id . "\n\n" . $content;
	if ($image_link != false) {
		$text = '[‍ ](' . $image_link . ')' . $text;
	}
	$text .= "\n" . "\n" . "@etuts #bot";

	$telegram->sendMessage([
		'chat_id' => $channel_id,
		'text' => $text,
		'parse_mode' => 'Markdown',
	]);

} catch (Exception $e) {
	$telegram->sendMessage([
		'chat_id' => $admin_id,
		'text' => $e->getPrevious(),
	]);
}