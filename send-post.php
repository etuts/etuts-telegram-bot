<?php 
/*
open a file that contains posts. each post on a line
send the post to channel (you may be able to require the codes of iraqsaqi (bayad beshe dige moshkeli nadare))
delete that line
*/
require('posts_file_class.php');
$file = Posts_file();
$file->open_read_file();
$post = $file->read_post();

require 'vendor/autoload.php';
require_once 'config.php';
use Telegram\Bot\Api;

// connecting
$telegram = new Api($token);

$telegram->sendMessage([
	'chat_id' => 92454,
	'text' => $post,
]);
