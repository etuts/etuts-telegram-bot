<?php 
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
?>