<?php

function run_start_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید'
	]);
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$commands = array();
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		if ($command["permission"] <= $permission)
			// $answer .= ("/".$command["name"]." - ".$command["description"]."\n");
			array_push($commands, $command["name"]);
	}
	$keyboard = [$commands];
		$reply_markup = $telegram->replyKeyboardMarkup([
			'keyboard' => $keyboard, 
			'resize_keyboard' => true, 
			'one_time_keyboard' => true
		]);

	run_help_command($chat_id, $text, $message_id, $message, $state);
}
