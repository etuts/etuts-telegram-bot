<?php

function run_start_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $keyboard_buttons, $db;
	
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$buttons = $keyboard_buttons["start"];
	log_debug(var_export($buttons, true), 117990761);
	$commands = array();
	$commands_to_ignore = array("help", "cancel", "start");
	
	foreach ($buttons as $command) {
		if ($command["permission"] <= $permission)
			if(!in_array($command["name"], $commands_to_ignore))
				array_push($commands, $command["name"]);
	}

	$keyboard = array_duplex($commands);

	$reply_markup = $telegram->replyKeyboardMarkup([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);

	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید',
		'reply_markup' => $reply_markup
	]);

	run_keyboard_button();
}
