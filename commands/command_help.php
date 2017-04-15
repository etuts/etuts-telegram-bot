<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands,$db;
	// $is_admin = check_user_permission(ADMIN);
	// $is_admin = true;
	$permission = get_user_permission();
	$answer = '';
	// $answer .= $admins;
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		$answer .= ("/".$command["name"]."\n");
	}
	$answer .= $permission;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}

?>