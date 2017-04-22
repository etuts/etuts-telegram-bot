<?php

function run_start_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $available_commands, $db;
	
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$commands = array();
	$commands_to_ignore = array("help", "cancel", "start");
	foreach ($available_commands as $command) {
		// log_debug(var_export($command, true), 117990761);
		if ($command["permission"] <= $permission)
			if(!in_array($command["name"], $commands_to_ignore))
				array_push($commands, $command["name"]);
	}
	$keyboard = oojoor($commands); // amin goft esmesho in bezar =)) baadan yeki avaz kone be couple
									// araye intory bar migardoone:   [["0", "1"]
									//  								["2", "3"]] ...
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
	// log_debug(var_export($state), 117990761);
	//run_help_command($chat_id, $text, $message_id, $message, $state);
}
