<?php

function run_help_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $available_commands,$db;
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$answer = '';
	foreach ($available_commands as $command) {
		if ($command["permission"] <= $permission)
			$answer .= ("/".$command["name"]." - ".$command["description"]."\n");
	}
	$btn1 = ['text' => '7', 'url' => 'http://etuts.ir'];
    $btn2 = ['text' => '7', 'url' => 'http://etuts.ir'];
    $keyboard = [ [$btn1, $btn2] ];
    $reply_markup = Telegram\Bot\Keyboard\Keyboard::make([ 'inline_keyboard' => $keyboard, ]);

    $telegram->sendMessage([
      'chat_id' => $chat_id, 
      'text' => 'Hello World', 
      'reply_markup' => $reply_markup,
    ]);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}
