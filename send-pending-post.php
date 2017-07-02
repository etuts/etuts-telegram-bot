<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/main-controller.php';

try {
	$db = new Database($db_name, $db_user, $db_pass, $chat_id, $message_id);
	$telegram = new Api($token);


	if (!isset($_POST['title']) ||
		!isset($_POST['post_link']) ||
		!isset($_POST['author_name']) ||
		!isset($_POST['author_username']) ||
	empty($_POST))
		die;


	// content of the message
	$title = $_POST['title'];
	$post_link = $_POST['post_link'];
	$author_name = $_POST['author_name'];
	$author_username = $_POST['author_username'];


	$text = emoji('sand_clock') . " یک مطلب در انتظار بررسی است\n\n".
			'<a href="'.$post_link.'">'.$title.'</a>' . "\n\n" .
			emoji('user') . ' نویسنده ی مطلب:‌ ' . $author_name . '(' . $author_username . ')' . "\n" .


	$telegram->sendMessage([
		'chat_id' => $admin_id,
		'text' => $text,
		'parse_mode' => 'HTML',
		'disable_web_page_preview' => true,
	]);

} catch (Exception $e) {
	log_debug($e->getPrevious());
}