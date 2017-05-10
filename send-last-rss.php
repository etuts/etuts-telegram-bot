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


$db = new Database($db_name, $db_user, $db_pass);
$telegram = new Api($token);
display_latest_post(9778738);
$rss = get_last_post();


// post display functions
function get_last_post(){
    file_put_contents("feed", fopen("http://etuts.ir/feed", 'r'));
    $rss = simplexml_load_file('feed');
    $last_item = $rss->channel->item;
    return $last_item;
}
function get_last_topic(){
    log_debug("entered functuon",97778738);
	file_put_contents("feed", fopen("http://etuts.ir/topics/feed", 'r'));
	$rss = simplexml_load_file('feed');
	$last_item = $rss->channel->item;
	return $last_item;
}
function make_post_for_channel($title, $description, $image_link = false, $link_to_site = false) {
    $image_link = ($image_link === false) ? '' : "[".'🖼'."](".$image_link.")";

    $link_to_site = ($link_to_site === false) ? '' : "[برای مشاهده ی مطلب کلیک کنید](".$link_to_site.")";
    
    $final_text =   $title.$image_link."\n".
                    $description."\n".
                    $link_to_site."\n".
                    "@etuts";
}
function display_latest_post($chat_id) {
    global $telegram;
    $post = get_last_post();
    $description = $post->description;
    $title = $post->title;

    //Getting image link from description 
    $text = "";
    $text .= $description;
    $pos = strpos($text, "src=\"") + 5;
    $text = substr($text,$pos);
    $pos2 = strpos($text, "\"");
    $image_link = substr($text,0,$pos2);

    $description = strip_tags($description);
    $description = substr($description, 0,strlen($description)-9);	//Removing garbage characters from description
    
    $link_to_site = $post->link;

    $final_text = make_post_for_channel($title, $description, $image_link, $link_to_site);
    echo $final_text;

    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $final_text,
        'parse_mode' => "Markdown",
    ]);
}
