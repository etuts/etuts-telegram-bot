<?php 

// debug functions - use'em just for debug
function log_debug($text, $chat_id = 92454) {
	global $telegram;
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $text
	]);

	$debug_file = fopen("log.txt","a");
	fwrite($debug_file, $text . PHP_EOL . "-------------------------\r\n");
	fclose($file);
}

// getters
function get_message_id() {
	global $db;
	$db->get_message_id();
}
function get_chat_id() {
	global $db;
	return $db->get_chat_id();
}
function get_fullname($chat_id = false) {
	global $db;
	return $db->get_fullname($chat_id);
}
function get_username($chat_id = false) {
	global $db;
	return $db->get_username($chat_id);
}

// senders - they send something to user with $telegram
function sendMessage($text, $force_reply = false) { // send message to current user
	global $telegram;
	$chat_id = get_chat_id();
	$data = [
		'chat_id' => $chat_id,
		'text' => $text
	];
	if ($force_reply) {
		$reply_markup = $telegram->forceReply();
		$data['reply_markup'] = $reply_markup;
	}
	$telegram->sendMessage($data);
}
function reply($text, $force_reply = false, $message_id = false) { // reply to current user
	global $telegram;
	$chat_id = get_chat_id();
	$data = [
		'chat_id' => $chat_id,
		'text' => $text
	];
	if ($message_id === false)
		$message_id = get_message_id();
	if ($force_reply) {
		$reply_markup = $telegram->forceReply();
		$data['reply_markup'] = $reply_markup;
	}
	$data['reply_to_message_id'] = $message_id;
	$telegram->sendMessage($data);
}
function send_message_to_admin($message, $text, $description, $reply_markup = false) { // send message to admin
	global $telegram, $db;
	$admins = $db->get_users_with_permission(ADMIN);
	
	$text = $description . PHP_EOL .
			'نام: ' . get_fullname() . PHP_EOL .
			'از: @' . get_username() . PHP_EOL .
			'متن: ' . $text;

	if ($reply_markup !== false) {
		foreach($admins as $admin_chat_id){
			$telegram->sendMessage([
				'chat_id' => $admin_chat_id,
				'text' => $text,
				'reply_markup' => $reply_markup,
			]);
		}
	} else {
		foreach($admins as $admin_chat_id){
			$telegram->sendMessage([
				'chat_id' => $admin_chat_id,
				'text' => $text,
			]);
		}
	}
}
function send_thank_message($message_id = false) { // send "thank you" to current user
	if ($message_id === false)
		$message_id = get_message_id();
	reply('با موفقیت انجام شد.');
}

// keyboard functions
function show_keyboard($keyboard_name, $text) { // gets the name of a keyboard from handle_keyboards file and shows all of its buttons to user
	global $keyboard_buttons, $telegram;
	$chat_id = get_chat_id();

	$keyboard = $keyboard_buttons[$keyboard_name];
	$keys = array();
	foreach($keyboard as $key){
		$keys[] = $key["name"];
	}

	$reply_markup = Telegram\Bot\Keyboard\Keyboard::make([
		'keyboard' => [$keys], 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);
	$telegram->sendMessage([
		'chat_id' =>  $chat_id, 
		'text' => $text, 
		'reply_markup' => $reply_markup,
	]);
}
function create_glassy_btn($text, $callback_function, $params = '') { // returns glassy btn
	$callback_data = [];
	$callback_data['f'] = $callback_function;
	$callback_data = array_merge($callback_data, $params);
	return [
		'text' => $text,
		'callback_data' => json_encode($callback_data),
	];
}
function create_glassy_keyboard($keyboard) { // just makes a given glassy keyboard
	return Telegram\Bot\Keyboard\Keyboard::make([ 'inline_keyboard' => $keyboard, ]);
}
