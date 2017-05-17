<?php 

function run_commands($text, $chat_id, $message_id, $message) {
	global $db;
	preg_match_all('/\/\w+/', $text, $commands);
	$command_class = substr($commands[0][0].'_command',1);
	if (class_exists($command_class)) {
		$permission = get_class_vars($command_class)['permission'];
		$is_author = $db->check_user_permission(AUTHOR);
		$is_admin = $db->check_user_permission(ADMIN);
		if ($permission == AUTHOR && !($is_author || $is_admin)) {
			reply('ببخشید اما شما نویسنده ی سایت نیستید!');
		} else if ($permission == ADMIN && !$is_admin) {
			reply('برای استفاده از این دستور باید ادمین کانال باشید');
		} else {
			$command = new $command_class();
			$command->run($chat_id, $text, $message_id, $message, IDLE);
		}
	}
}

function is_cancel_command($text, $chat_id, $message_id, $message) {
	if (contains_word($text, "/cancel")) {
		$command = new cancel_command();
		$command->run($chat_id, $text, $message_id, $message, IDLE);
		return true;
	}
	return false;
}

require "./commands/base_command.php";
foreach (glob("./commands/command_*.php") as $filename) {
    require ($filename);
}
