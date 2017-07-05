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
		!isset($_POST['comment_date']) ||
		!isset($_POST['comment_id']) ||
	empty($_POST))
		die;


	// content of the message
	$author_username = $_POST['author_username'];
	$post_title = $_POST['post_title'];
	$post_link = $_POST['post_link'];
	$comment_content = strip_tags($_POST['comment_content']);
	$comment_author = $_POST['comment_author'];
	$comment_date = $_POST['comment_date'];
	$comment_id = $_POST['comment_id'];


	$set_status_url = 'http://etuts.ir/wp-content/plugins/etuts-specific-plugin/scripts/set-comment-status.php?comment_id='.$comment_id . '&';


	$text = emoji('post_letter_box') . ' شما یک کامنت جدید در مطلب <a href="'.$post_link.'">'.$post_title.'</a> دارید:' . "\n\n" .
			emoji('user') . ' نویسنده ی کامنت:‌ ' . $comment_author . "\n" .
			emoji('clock') . ' در تاریخ: ' . $comment_date . "\n" .
			emoji('blue_diamond') . ' متن کامنت:‌ ' . $comment_content;

// glassy buttons
	$approve_btn = create_glassy_link_btn(emoji('checked') . ' پذیرفتن', $set_status_url . "comment_status=approve");
	$spam_btn = create_glassy_link_btn(emoji('forbidden') . ' اسپم', $set_status_url . "comment_status=spam");
	$trash_btn = create_glassy_link_btn(emoji('trash') . ' حذف', $set_status_url . "comment_status=trash");
	$keyboard = create_glassy_keyboard([[$approve_btn, $spam_btn, $trash_btn]]);

	$chat_id = $db->get_chat_id_by_etuts_user($author_username);
	
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $text,
		'parse_mode' => 'HTML',
		'disable_web_page_preview' => true,
		'reply_markup' => $keyboard,
	]);
	log_debug("send-last-rss.php"); //debug

} catch (Exception $e) {
	log_debug($e->getPrevious());
}