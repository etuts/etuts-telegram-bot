#!/usr/bin/php
<?php 
/*
open a file that contains posts. each post on a line
send the post to channel (you may be able to require the codes of iraqsaqi (bayad beshe dige moshkeli nadare))
delete that line
*/

require __DIR__.'vendor/autoload.php';
require_once __DIR__.'config.php';
use Telegram\Bot\Api;

require __DIR__.'posts_file_class.php';

$file = new Posts_file(false);

if ($file) {
	
	$post = $file->read_post();
	
	$telegram = new Api($token);
	
	$telegram->sendMessage([
		'chat_id' => 92454,
		'text' => $post,
	]);
} else
	echo 'failed' . PHP_EOL;

