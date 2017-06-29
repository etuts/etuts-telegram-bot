<?php 

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/main-controller.php';

try {
	$db = new Database($db_name, $db_user, $db_pass, $chat_id, $message_id);
	$telegram = new Api($token);
	if (!isset($_POST['author_username']) ||
		!isset($_POST['post_title']) ||
		!isset($_POST['post_link']) ||
		!isset($_POST['comment_content']) ||
		!isset($_POST['comment_author']) ||
		!isset($_POST['comemnt_date']) ||
		!isset($_POST['comment_id']) ||
	empty($_POST))
		die;


	// content of the message
	$author_username = $_POST['author_username'];
	$post_title = $_POST['post_title'];
	$post_link = $_POST['post_link'];
	$comment_content = strip_tags($_POST['comment_content']);
	$comment_author = $_POST['comment_author'];
	$comemnt_date = $_POST['comemnt_date'];
	$comment_id = $_POST['comment_id'];


	$text = 'شما یک کامنت جدید در مطلب <a href="'.$post_link.'">"'.$post_title.'"</a> دارید:' . "\n\n" .
			emoji('clock') . ' در تاریخ: ' . $comment_date . "\n\n" .
			emoji('blue_diamond') . ' متن کامنت:‌ ' . $comment_content . "\n\n";

	$chat_id = $db->get_chat_id_by_username($author_username);
	
// log_debug("مطلبی که رفته بود تو کانال دوباره داشت میفرت تو کانال " . $_POST['debug'] . ' ' . $text . ' ' . $channel_id);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $text,
		'parse_mode' => 'HTML',
	]);

} catch (Exception $e) {
	log_debug($e->getPrevious());
}