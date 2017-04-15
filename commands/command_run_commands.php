<?php

function run_commands($text, $chat_id, $message_id, $message) {
	global $available_commands;
	$command = get_command($text);
	foreach ($command as $cmd) {
		$func = 'run_' . $available_commands[$cmd]["name"] . '_command';
		$func($chat_id, $text, $message_id, $message);
	}
}

?>