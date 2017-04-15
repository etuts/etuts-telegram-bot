<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require_once 'config.php';

//--------------------- Enum of permissions ----------------------
define("ADMIN", 1);
define("AUTHOR", 2);

//--------------------- Enum of STATEs --------------------------
define("IDLE", 0);
define("CONTACT", 1);
define("POST_VALIDATION_SEND_POST_TITLE", 2);

//--------------------- database class --------------------------
class Database {
	protected $db_name;
	protected $db_user;
	protected $db_pass;
	protected static $db;
	protected $chat_id;

	function __construct($db_name, $db_user, $db_pass, $chat_id) {
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db = mysqli_connect('localhost',$this->db_user,$this->db_pass,$this->db_name) or die('Error connecting to MySQL server.');
		$this->chat_id = $chat_id;
		return $this->db;
	}
	function get_user_row() {
		return mysqli_query($this->db, "SELECT * FROM `chats` WHERE chat_id = '$this->chat_id' ");
	}
	function insert($state, $text, $permission = 0) {
		return mysqli_query($this->db, "INSERT INTO `chats` (chat_id, state, last_message, permission) VALUES ('$this->chat_id', '$state', '$text', '$permission') ");
	}
	function set_permission($permission) {
		return mysqli_query($this->db, "UPDATE `chats` SET permission = '$permission' WHERE chat_id = '$this->chat_id' ");
	}
	function get_state() {
		$result = mysqli_query($this->db, "SELECT `state` FROM `chats` WHERE chat_id = '$this->chat_id' ");
		return (int)$result->fetch_assoc()['state'];
	}
	function update_last_message($text) {
		return mysqli_query($this->db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$this->chat_id' ");
	}
	function set_state($state) {
		return mysqli_query($this->db, "UPDATE `chats` SET state = '$state' WHERE chat_id = '$this->chat_id' ");
	}
	function reset_state() {
		return db_set_state($this->chat_id,0);
	}
	function check_user_permission($permission) {
		$result = mysqli_query($this->db, "SELECT * FROM `chats` WHERE (chat_id, permission) = ('$this->chat_id', '$permission') ");
		return mysqli_num_rows($result) == 1;
	}
	function user_already_exists() {
		$result = $this->get_user_row();
		return mysqli_num_rows($result) == 0;
	}
}
//--------------------- end of database class -------------------



//--------------------- database functions ------------------
// get chat state from database
function get_chat_state($chat_id, $text) {
	global $db;
	$state = IDLE; // no state
	if ($db->user_already_exists()) {
		$db->insert(0, $text);
	} else {
		$state = $db->get_state();
		$db->update_last_message($text);
	}
	return $state;
}
function handle_state($state, $chat_id, $text, $message_id, $message) {
	global $db;
	switch ($state) {
		case IDLE:
			// user has sent chert o pert! execute help command
			break;
		case CONTACT:
			// user has sent a message to admin! Wow!!
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'یک تماس جدید');
			$db->reset_state();
			break;
		case POST_VALIDATION_SEND_POST_TITLE:
			// user has sent title and link of a post to validate
			send_thank_message($chat_id, $message_id);
			send_message_to_admin($message, $text, 'مطلب جدید در انتظار بررسی');
			$db->reset_state();
			break;
	}
}
function add_admin($chat_id) {
	global $db;
	$db->set_permission(ADMIN);
}

//--------------------- telegram bot api functions ---------------
$keyboard_buttons = ['معرفی ربات'];

function run_keyboard_buttons($text, $chat_id, $message_id, $message) {
	global $keyboard_buttons;
	$is_keyboard_button = false;
	$btn = get_keyboard_button($text);
	if ($btn !== false) {
		$is_keyboard_button = true;
		$func = 'keyboard_button_' . convert_to_english($text);
		log_debug($func);
		$func($btn, $text, $chat_id, $message_id, $message);
	}
	return $is_keyboard_button;
}
function get_keyboard_button($text) {
	global $keyboard_buttons;
	$keyboard_button = false;
	foreach ($keyboard_buttons as $btn) {
		if ($text == $btn)
			$keyboard_button = $btn;
	}
	return $keyboard_button;
}
// keyboard buttons seperated functions
function keyboard_button_lubtdbfhj($btn, $text, $chat_id, $message_id, $message) { // معرفی ربات
	// should read a file where we store all the posts in there (there should be some functions to work with this file)
}



//--------------------- telegram bot command functions -----------
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

//--------------------- telegram bot api helper functions ---------
function send_message_to_admin($message, $text, $description) {
	global $telegram;
	$username = $message->getFrom()->getUsername();
	$firstname = $message->getFrom()->getFirstName();
	$lastname = $message->getFrom()->getLastName();
	$text = $description . PHP_EOL .
			'نام: ' . $firstname . ' ' . $lastname . PHP_EOL .
			'از: @' . $username . PHP_EOL .
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
	fwrite($debug_file, $text . PHP_EOL . "-------------------------\r\n");
	fclose($file);
}
function convert_to_english($text) {
	$persian = array('ض','ص','ث','ق','ف','غ','ع','ه','خ','ح','ج','چ','ش','س','ی','ب','ل','ا','ت','ن','م','ک','گ','ظ','ط','ز','ر','ذ','د','پ','و',' ');
	$english = array('q','w','e','r','t','y','u','i','o','p','_1','_2','a','s','d','f','g','h','j','k','l','_3','_4','z','x','cv','b','n','m','_5','_');
	return str_replace($persian, $english, $text);
}

?>