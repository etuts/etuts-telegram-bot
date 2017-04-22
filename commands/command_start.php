<?php

function run_start_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $available_commands, $db;
	
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$commands = array();
	$commands_to_ignore = ["help", "cancel", "start"];
	foreach ($available_commands as $command) {
		// log_debug(var_export($command, true), 117990761);
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		if ($command["permission"] <= $permission)
			if(!in_array(command["name"], $commands_to_ignore))
			// $answer .= ("/".$command["name"]." - ".$command["description"]."\n");
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

function oojoor($arr){
	$ans = array();
	$cnt = 0;
	for($i = 0; $i < sizeof($arr)/2 ; $i += $cnt%0){
		array_push($ans, []);
		foreach($arr as $ind){
			array_push($ans[i], $ind);
		}
	}
	log_debug(var_export($ans, true), 117990761);
}

?>