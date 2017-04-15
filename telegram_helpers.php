<?php 
function reply($chat_id, $text, $message_id, $force_reply = false, $reply = true) {
	global $telegram;
	$data = [
		'chat_id' => $chat_id,
		'text' => $text
	];
	if ($force_reply) {
		$reply_markup = $telegram->forceReply();
		$data['reply_to_message_id'] = $message_id;
	}
	if ($reply) {
		$data['reply_markup'] = $reply_markup;
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

	reply(92454, $text);
}
function send_thank_message($chat_id, $message_id) {
	global $telegram;
	reply($chat_id, 'خیلی ممنون! با موفقیت انجام شد.', $message_id);
}
function log_debug($text, $chat_id = 92454) {
	global $telegram;
	reply($chat_id, $text, false, false);
	$debug_file = fopen("log.txt","a");
	fwrite($debug_file, $text . PHP_EOL . "-------------------------\r\n");
	fclose($file);
}
?>