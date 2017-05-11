<?php 

$available_commands = [

	"/contact" => array("name"=>"contact", "description"=>"تماس با ما", "permission"=>USER),
	"/post_validation" => array("name"=>"post_validation", "description"=>"نویسنده های سایت می توانند مطلبی که می خواهند بنویسند را از این طریق به ادمین اطلاع دهند تا ادمین تایید کند", "permission"=>AUTHOR),
	"/cancel" => array("name"=>"cancel", "description"=>"لغو هر عملیاتی که در حال انجام آن هستید", "permission"=>USER),
	"/schedule_post" => array("name"=>"schedule_post", "description"=>"زمانبندی مطلب برای ارسال در کانال", "permission"=>ADMIN),
	"/start" => array("name"=>"start", "description"=>"شروع ربات", "permission"=>USER),
	"/help" => array("name"=>"help", "description"=>"دستور راهنما", "permission"=>USER),
	"/request_post" => array("name"=>"request_post", "description"=>"درخواست مطلب آموزشی - اگر آموزشی لازم دارید به ما اطلاع دهید", "permission"=>USER),
	"/categories" => array("name"=>"categories", "description"=>"انتخاب دسته بندی ها برای دریافت آخرین مطالب سایت", "permission"=>USER),
	"/remove_last_post" => array("name"=>"remove_last_channel_post", "description"=>"پاک کردن آخرین پست زمانبندی شده ی کانال", "permission"=>ADMIN),
	"/post_source" => array("name"=>"post_source", "description"=>"پیشنهاد دادن مطلبی برای نویسنده ها که در سایت بنویسند", "permission"=>ADMIN),
	"/get_recommended_post" => array("name"=>"get_recommended_post", "description"=> "یک مطلب برای نوشتن در سایت به شما پیشنهاد می دهد", "permission"=>AUTHOR),
	"/manage_channel_posts" => array("name"=>"manage_channel_posts", "description"=> "مدیریت پست های زمانبندی شده برای کانال", "permission"=>ADMIN),
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
