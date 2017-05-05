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
	"/remove_nth_post" => array("name"=>"remove_nth_channel_post", "description"=>"description of remove nth channel post", "permission"=>ADMIN),
	"/post_source" => array("name"=>"post_source", "description"=>"description of post source", "permission"=>ADMIN),
	"/get_recommended_post" => array("name"=>"get_recommended_post", "description"=> "description of get recommended post", "permission"=>AUTHOR)
];

function run_commands($text, $chat_id, $message_id, $message) {
	global $available_commands, $db;

	foreach ($available_commands as $cmd=>$command_array) {
		if (contains_word($text, $cmd)) {
			if ($command_array['permission'] == AUTHOR && !($db->check_user_permission(AUTHOR) || $db->check_user_permission(ADMIN))) {
				reply('ببخشید اما شما نویسنده ی سایت نیستید!');
			} else if ($command_array['permission'] == ADMIN && !$db->check_user_permission(ADMIN)) {
				reply('برای استفاده از این دستور باید ادمین کانال باشید');
			} else {
				$func = 'run_' . $command_array["name"] . '_command';
				$func($chat_id, $text, $message_id, $message, IDLE);
			}
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
