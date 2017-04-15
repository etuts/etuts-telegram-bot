<?php 

$available_commands = [

	"/contact" => array("name"=>"contact", "description"=>"description of contact"),
	"/post_validation" => array("name"=>"post_validation", "description"=>"description of post_validation"),
	"/cancel" => array("name"=>"cancel", "description"=>"description of cancel"),
	"/schedule_post" => array("name"=>"schedule_post", "description"=>"description of schedule_post"),
	"/start" => array("name"=>"start", "description"=>"description of start"),
	"/help" => array("name"=>"help", "description"=>"description of help"),

];

function get_command($text) {
	global $available_commands;
	$contain_these_commands = array();
	foreach ($available_commands as $command=>$command_array) {
		if (contains_word($text, $command))
			$contain_these_commands[] = $command;
	}
	return $contain_these_commands;
}
function run_commands($text, $chat_id, $message_id, $message) {
	global $available_commands;
	$command = get_command($text);
	foreach ($command as $cmd) {
		$func = 'run_' . $available_commands[$cmd]["name"] . '_command';
		$func($chat_id, $text, $message_id, $message);
	}
}

foreach (glob("./commands/*.php") as $filename) {
    require ($filename);
}
