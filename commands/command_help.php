<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands,$db;
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$answer = '';
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		if ($command["permission"] <= $permission)
			$answer .= ("/".$command["name"]." - ".$command["description"]."\n");
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
	// $chat_id2 = "@mytest2testchannel";
	// $text2 = "Testing the text";
	// $telegram->sendMessage([
	// 	'chat_id' => $chat_id2,
	// 	'text' => $text2,
	// ]);
}

?>