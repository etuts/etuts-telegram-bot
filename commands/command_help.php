<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands,$db;
	// $is_admin = check_user_permission(ADMIN);
	$is_admin = true;
	$answer = '';
	// $answer .= $admins;
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		$answer .= ("/".$command["name"]."\n");
	}
	if ($is_admin)
			$answer.("You are Admin\n");
	else
		$answer.("You are note Admin\n");
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}

?>