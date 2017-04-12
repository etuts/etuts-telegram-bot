<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

//--------------------- Enum of permissions ----------------------
define("ADMIN", 1);
define("AUTHOR", 2);

//--------------------- Enum of STATEs ----------------------
define("CANCEL", 0);
define("CONTACT", 1);
define("POST_VALIDATION_SEND_POST_TITLE", 2);

//--------------------- database functions ------------------
function db_get_user_row($chat_id) {
	global $db;
	return mysqli_query($db, "SELECT * FROM `chats` WHERE chat_id = '$chat_id' ");
}
function db_get_state($chat_id) {
	global $db;
	$result = mysqli_query($db, "SELECT `state` FROM `chats` WHERE chat_id = '$chat_id' ");
	return (int)$result->fetch_assoc()['state'];
}
function db_insert($chat_id, $state, $text, $permission = 0) {
	global $db;
	return mysqli_query($db, "INSERT INTO `chats` (chat_id, state, last_message, permission) VALUES ('$chat_id', '$state', '$text', '$permission') ");
}
function db_update_last_message($chat_id, $text) {
	global $db;
	return mysqli_query($db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$chat_id' ");
}
function db_set_state($chat_id, $state) {
	global $db;
	return mysqli_query($db, "UPDATE `chats` SET state = '$state' WHERE chat_id = '$chat_id' ");
}
function db_reset_state($chat_id) {
	return db_set_state($chat_id,0);
}
function db_check_user_permission($chat_id, $permission) {
	global $db;
	$result = mysqli_query($db, "SELECT * FROM `chats` WHERE (chat_id, permission) = ('$chat_id', '$permission') ");
	return mysqli_num_rows($result) == 1;
}
function db_set_permission($chat_id, $permission) {
	global $db;
	return mysqli_query($db, "UPDATE `chats` SET permission = '$permission' WHERE chat_id = '$chat_id' ");
}

// get chat state from database
function get_chat_state($chat_id, $text) {
	$result = db_get_user_row($chat_id);
	$state = CANCEL; // no state
	if (mysqli_num_rows($result) == 0) {
	    db_insert($chat_id, 0, $text);
	} else {
		$state = db_get_state($chat_id);
		db_update_last_message($chat_id, $text);
	}
	return $state;
}
function handle_state($state, $chat_id, $text, $message_id, $message) {
	switch ($state) {
		case CANCEL:
			// user has sent chert o pert! execute help command
			break;
		case CONTACT:
			// user has sent a message to admin! Wow!!
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'یک تماس جدید');
			db_reset_state($chat_id);
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			// user has sent title and link of a post to validate
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'مطلب جدید در انتظار بررسی');
			db_reset_state($chat_id);
			break;
	}
}
function add_admin($chat_id) {
	db_set_permission($chat_id, ADMIN);
}

//--------------------- telegram bot api functions ---------------
$available_commands = ['/contact','/post_validation','/cancel','/scheduale_post'];

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

//--------------------- telegram bot command functions -------------
function run_cancel_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	db_reset_state($chat_id);
	$reply_markup = $telegram->replyKeyboardHide();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'tetx' => 'عملیات با موفقیت کنسل شد',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function run_contact_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	db_set_state($chat_id, CONTACT);
	$reply_markup = $telegram->forceReply();
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'لطفا پیام تان را بفرستید',
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function run_post_validation_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	if (db_check_user_permission($chat_id, AUTHOR) || db_check_user_permission($chat_id, ADMIN)) {
		db_set_state($chat_id, POST_VALIDATION_SEND_POST_TITLE);
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
function run_scheduale_post_command($chat_id, $text, $message_id, $message) {
	global $telegram;
	if (db_check_user_permission($chat_id, ADMIN)) {
		$answer = 'نوع مطلبی که میخوای بفرستی رو مشخص کن' . "\r\n";
		$keyboard = [
		    ['معرفی ربات', 'معرفی ابزار']
		];
		$reply_markup = $telegram->replyKeyboardMarkup([
			'keyboard' => $keyboard, 
			'resize_keyboard' => true, 
			'one_time_keyboard' => true
		]);
		$reply_markup = $telegram->forceReply();
	} else {
		$answer = 'برای استفاده از این دستور باید ادمین کانال باشید';
	}
	$telegram->sendMessage([
		$chat_id => $chat_id,
		$text => $answer,
		'reply_markup' => $reply_markup
	]);
}

//--------------------- telegram bot api helper functions ---------
function send_message_to_admin($message, $text, $description) {
	global $telegram;
	$username = $message->getFrom()->getUsername();
	$firstname = $message->getFrom()->getFirstName();
	$lastname = $message->getFrom()->getLastName();
	$text = $description . "\r\n" .
			'نام: ' . $firstname . ' ' . $lastname . "\r\n" .
			'از: @' . $username . "\r\n" .
			'متن: ' . $text;

	/*$inline_keyboard_button = [
		'text' => 'hi'
	];
	$inline_keyboard_buttons = array();
	$inline_keyboard_buttons[] = $inline_keyboard_button;

	$reply_markup = $telegram->inlineKeyboardMarkup([
		'inline_keyboard' => $inline_keyboard_buttons
	]);*/

/*	$keyboard = [
	    ['7', '8', '9'],
	    ['4', '5', '6'],
	    ['1', '2', '3'],
	         ['0']
	];*/
/*	$reply_markup = $telegram->replyKeyboardMarkup([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);*/

/*	$keyboard = Telegram\Bot\Keyboard\Keyboard::make([
		'keyboard' => $keyboard, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);*/
	// $keyboard->inline();
	// $reply_markup->inline();

	$telegram->sendMessage([
	  'chat_id' => 92454,
	  'text' => $text,
	  // 'reply_markup' => $reply_markup
	]);
}
function send_thank_message($chat_id, $message_id) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'خیلی ممنون! با موفقیت انجام شد.',
		'reply_to_message_id' => $message_id
	]);
}

//--------------------- helpers -------------------------------
function contains_word($source, $find) {
	if (strpos($source, $find) !== false)
		return true;
	return false;
}
function log_debug($text) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => 92454,
		'text' => $text
	]);
	$debug_file = fopen("log.txt","a");
	fwrite($debug_file, "-------------------------\r\n" . $text . "\r\n");
	fclose($file);
}

?>