<?php 
$available_commands = ['/contact','/post_validation','/cancel','/schedule_post','/start','/help'];

function run_commands($text, $chat_id, $message_id, $message) {
	global $available_commands;
	$commands_index = get_command($text);
	foreach ($commands_index as $command_index) {
		$func = 'run_' . ltrim($available_commands[$command_index], '/') . '_command';
		$func($chat_id, $text, $message_id, $message);
	}
}
function get_command($text) {
	global $available_commands;
	$contain_these_commands = array();
	foreach ($available_commands as $index=>$command) {
		if (contains_word($text, $command))
			$contain_these_commands[] = $index;
	}
	return $contain_these_commands;
}
// command seperated functions
function run_start_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خوش آمدید'
	]);

	run_help_command($chat_id, $text, $message_id, $message);
}
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
function run_cancel_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	$db->reset_state();
	$reply_markup = $telegram->replyKeyboardHide();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'عملیات با موفقیت کنسل شد',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function run_contact_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	$db->set_state(CONTACT);
	$reply_markup = $telegram->forceReply();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'لطفا پیام تان را بفرستید',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function run_post_validation_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	if ($db->check_user_permission(AUTHOR) || $db->check_user_permission(ADMIN)) {
		$db->set_state(POST_VALIDATION_SEND_POST_TITLE);
		$answer = 'عنوان مطلب و لینک مطلبی که می خواهید بنویسید را وارد کنید';
		$reply_markup = $telegram->forceReply();
	} else {
		$answer = 'ببخشید اما شما نویسنده ی سایت نیستید!';
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function run_schedule_post_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	if ($db->check_user_permission(ADMIN)) {
		$answer = 'نوع مطلبی که میخوای بفرستی رو مشخص کن' . PHP_EOL;
		$keyboard = [['معرفی ربات', 'معرفی ابزار']];
		$reply_markup = $telegram->replyKeyboardMarkup([
			'keyboard' => $keyboard, 
			'resize_keyboard' => true, 
			'one_time_keyboard' => true
		]);
		// $reply_markup = $telegram->forceReply();
	} else {
		$answer = 'برای استفاده از این دستور باید ادمین کانال باشید';
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
		'reply_markup' => $reply_markup
	]);
}
?>