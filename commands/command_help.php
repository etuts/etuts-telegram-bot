<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands,$db;
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	// $is_user = $db->check_user_permission(USER);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	// $is_admin = true;
	// $permission = get_user_permission();
	$answer = '';
	// $answer .= $admins;
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		$answer .= ("/".$command["name"]." - ".$command["description"]."\n");
	}
	if ($is_admin)
		$answer .= "Admin";
	else
		$answer .= "Not Admin";
	$answer .= $permission;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}

?>