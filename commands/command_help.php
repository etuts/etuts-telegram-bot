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
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
	$text = " saaaasda";
	$post = get_last_post();
	$text .= $post->description;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $text,
		'parse_mode' => 'Markdown',

	]);
	

	
}
