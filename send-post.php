<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/main-controller.php';

try {
	$telegram = new Api($token);
	if (empty($_POST) || !isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['bot_id']) || !isset($_POST['image_link']))
		die;


	// content of the message
	$title = $_POST['title'];
	$content = $_POST['content'];
	$image_link = $_POST['image_link'];
	$bot_id = $_POST['bot_id'];

	$text = $title . "\n\n" . emoji('id') . ' @' . $bot_id . "\n\n" . $content;
	if ($image_link != false) {
		$text = '<a href="'.$image_link.'">‍ </a>' . $text;
	}
	$text .= "\n" . "\n" . "@etuts #bot";


	$telegram->sendMessage([
		'chat_id' => $channel_id,
		'text' => $text,
		'parse_mode' => 'HTML',
	]);

} catch (Exception $e) {
	log_debug($e->getPrevious());
}