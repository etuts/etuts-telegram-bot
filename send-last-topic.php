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

$telegram = new Api($token);
send_last_topic(97778738);
function get_last_topic(){
	file_put_contents("feed", fopen("http://etuts.ir/topics/feed", 'r'));
	$rss = simplexml_load_file('feed');
	$last_item = $rss->channel->item;
	return $last_item;
}
function send_last_topic($chat_id){
	global $telegram;
	$topic = get_last_topic();
	$text = "عنوان آخرین تاپیک : \n"."[".$topic->title."](".$topic->link.")";
	$telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "Markdown",
    ]);
}