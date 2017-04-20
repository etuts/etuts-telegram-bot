<?php 
function get_chat_id() {
	global $db;
	return $db->get_chat_id();
}
function reply($text, $message_id, $force_reply = false, $reply = true) {
	global $telegram, $db;
	$chat_id = $db->get_chat_id();
	$data = [
		'chat_id' => $chat_id,
		'text' => $text
	];
	if ($force_reply) {
		$reply_markup = $telegram->forceReply();
		$data['reply_markup'] = $reply_markup;
	}
	if ($reply) {
		$data['reply_to_message_id'] = $message_id;
	}
	$telegram->sendMessage($data);
}
function send_message_to_admin($message, $text, $description) {
	global $telegram;
	$username = $message->getFrom()->getUsername();
	$firstname = $message->getFrom()->getFirstName();
	$lastname = $message->getFrom()->getLastName();
	$text = $description . PHP_EOL .
			'نام: ' . $firstname . ' ' . $lastname . PHP_EOL .
			'از: @' . $username . PHP_EOL .
			'متن: ' . $text;

	$telegram->sendMessage([
		'chat_id' => 92454,
		'text' => $text
	]);
}
function send_thank_message($message_id) {
	reply('خیلی ممنون! با موفقیت انجام شد.', $message_id);
}
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
function show_keyboard($keyboard_name, $text) {
	global $keyboard_buttons, $db;
	$chat_id = $db->get_chat_id();

	$keyboard = $keyboard_buttons[$keyboard_name];
	$keys = array();
	foreach($keyboard as $key){
		$keys[] = $key["name"];
	}
	log_debug(var_export($keys, true), 117990761);
	$reply_markup = Telegram\Bot\Keyboard\Keyboard::make([
		'keyboard' => $keys, 
		'resize_keyboard' => true, 
		'one_time_keyboard' => true
	]);

	$telegram->sendMessage([
		'chat_id' => $chat_id, 
		'text' => $text, 
		'reply_markup' => $reply_markup,
	]);
}
