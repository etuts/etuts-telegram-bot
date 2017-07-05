#!/usr/bin/php
<?php 
/*
open a db that contains posts. each post on a line
send the post to channel (you may be able to require the codes of iraqsaqi (bayad beshe dige moshkeli nadare))
delete that line
*/

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;
require __DIR__.'/database_class.php';
require __DIR__.'/telegram_helpers.php';
require __DIR__.'/utilities.php';


$db = new Database($db_name, $db_user, $db_pass);
$telegram = new Api($token);


if (empty($_POST) && !isset($_POST['title']) && !isset($_POST['excerpt']) && !isset($_POST['image_link']) && !isset($_POST['category']) && !isset($_POST['post_link']))
	die('not post request');


$title = $_POST['title'];
$excerpt = $_POST['excerpt'];
$image_link = $_POST['image_link'];
$category = $_POST['category'];
$post_link = $_POST['post_link'];


send_last_post_to_users($title , $excerpt , $category , $image_link , $post_link);

log_debug("send-last-rss.php"); //debug
function make_post_for_channel($title, $content, $category, $image_link, $post_link) {
	$image_link = ($image_link === false) ? '' : "[‍ ](".$image_link.")";

	$post_link = "[برای مشاهده ی مطلب کلیک کنید](".$post_link.")";
	
	$final_text =   emoji('bullhorn') . ' ' . $title . ' ' . $image_link . "\n" . 
					'دسته: ' . emoji($category['emoji']) . ' ' . $category['name'] . "\n\n" . 
					emoji('note') . ' ' . $content . "\n\n" . 
					$post_link . "\n" . 
					"@etuts";
	return $final_text;
}
function display_latest_post($chat_id, $title, $content, $category, $image_link, $post_link) {
	global $telegram;
	
	$content = strip_tags($content);
	
	$final_text = make_post_for_channel($title, $content, $category, $image_link, $post_link);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $final_text,
		'parse_mode' => "Markdown",
	]);
}
function send_last_post_to_users($title, $content, $category, $image_link, $post_link){
	global $categories_array, $db, $telegram;

	$category_index = -1;
	for ($i = 0 ; $i < count($categories_array); $i++)
		if ($categories_array[$i]['name'] == $category)
			$category_index = $i;

	if ($category_index == -1)
		return false;

	$users_chat_id = $db->get_all_users_chat_id();
	foreach ($users_chat_id as $user){
		$user_categories = $db->get_categories_checked_array($user);
		if ($user_categories[$category_index] == 1)
			display_latest_post($user, $title, $content, $categories_array[$category_index], $image_link, $post_link);
	}
	return true;
}
