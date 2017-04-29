<?php 

$available_commands = [

	"/contact" => array("name"=>"contact", "description"=>"description of contact", "permission"=>USER),
	"/post_validation" => array("name"=>"post_validation", "description"=>"description of post_validation", "permission"=>AUTHOR),
	"/cancel" => array("name"=>"cancel", "description"=>"description of cancel", "permission"=>USER),
	"/schedule_post" => array("name"=>"schedule_post", "description"=>"description of schedule_post", "permission"=>ADMIN),
	"/start" => array("name"=>"start", "description"=>"description of start", "permission"=>USER),
	"/help" => array("name"=>"help", "description"=>"description of help", "permission"=>USER),
	"/request_post" => array("name"=>"request_post", "description"=>"description of request_post", "permission"=>USER),
	"/categories" => array("name"=>"categories", "description"=>"description of categories", "permission"=>USER),
	"/remove_last_post" => array("name"=>"remove_last_channel_post", "description"=>"description of remove last channel post", "permission"=>ADMIN),
];

function run_commands($text, $chat_id, $message_id, $message) {
	global $available_commands;

	foreach ($available_commands as $cmd=>$command_array) {
		if (contains_word($text, $cmd)) {
			$func = 'run_' . $command_array["name"] . '_command';
			$func($chat_id, $text, $message_id, $message, IDLE);
		}
	}
}

function is_cancel_command($text, $chat_id, $message_id, $message) {
	global $available_commands;

	if (contains_word($text, "/cancel")) {
		$func = 'run_' . $available_commands["/cancel"]['name'] . '_command';
		$func($chat_id, $text, $message_id, $message, IDLE);
		return true;
	}
	return false;
}

foreach (glob("./commands/command_*.php") as $filename) {
    require ($filename);
}
