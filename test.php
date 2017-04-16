<?php

// requirements
require 'vendor/autoload.php';
require_once 'config.php';
require 'functions.php';
use Telegram\Bot\Api;

// connecting
$telegram = new Api($token);
$chat_id = "@mytest2testchannel";
$text = "Hello";
$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $text,
	]);
?>