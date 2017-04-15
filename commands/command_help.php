<?php

function run_help_command($chat_id, $text, $message_id, $message) {
	global $telegram, $available_commands;
	$answer = '';
	foreach ($available_commands as $index => $command) {
		$answer .= sprintf('%s'.PHP_EOL, $command);
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
}

?>