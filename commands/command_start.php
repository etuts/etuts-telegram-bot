<?php

function run_start_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید'
	]);

	run_help_command($chat_id, $text, $message_id, $message);
}

?>