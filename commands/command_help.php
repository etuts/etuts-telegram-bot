<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands,$db;
	$admins = $db->get_admins();
	$answer = '';
	$answer .= $admins;
	foreach ($available_commands as $command) {
		// $answer .= sprintf('%s'.PHP_EOL, $command["name"]);
		$answer .= ("/".$command["name"]."\n");
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}

?>