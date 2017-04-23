<?php 
function get_chat_id() {
	global $db;
	return $db->get_chat_id();
}
function sendMessage($text, $force_reply = false) {
	reply($text, null, $force_reply, false);
}
function get_fullname($chat_id = false) {
	global $db;
	return $db->get_fullname($chat_id);
}
function get_username($chat_id = false) {
	global $db;
	return $db->get_username($chat_id);
}
function reply($text, $message_id, $force_reply = false, $reply = true) {
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
	if ($reply) {
		$data['reply_to_message_id'] = $message_id;
	}
	$telegram->sendMessage($data);
}
function send_message_to_admin($message, $text, $description, $reply_markup = false) {
	global $telegram;
	$text = $description . PHP_EOL .
			'نام: ' . get_fullname() . PHP_EOL .
			'از: @' . get_username() . PHP_EOL .
			'متن: ' . $text;

	if ($reply_markup !== false) {
		$telegram->sendMessage([
			'chat_id' => 92454,
			'text' => $text,
			'reply_markup' => $reply_markup,
		]);
	} else {
		$telegram->sendMessage([
			'chat_id' => 92454,
			'text' => $text,
		]);
	}
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
function get_key_btn($f, $c, $m, $more_data = '') {
	return ['text' => 'پاسخ', 'callback_data' => '{"f":"'.$f.'","c":'.$c.',"m":'.$m. (($more_data == '') ? $more_data : ',' . $more_data) .'}'];
}
function make_keyboard($keyboard) {
	return Telegram\Bot\Keyboard\Keyboard::make([ 'inline_keyboard' => $keyboard, ]);
}
function get_last_post(){
	file_put_contents("feed", fopen("http://etuts.ir/feed", 'r'));
	$rss = simplexml_load_file('feed');
	$last_item = $rss->channel->item;
	return $last_item;
}
function emoji($text){
	global $emojis;
	return $emojis[$text];
}
$emojis = [
	'laugh' => '😂',
	'poker' => '😐',
	':D' => '😁',
	'thinking' => '🤔',
	'like' => '👍',
	'exact' => '👌',
	'hand' => '✋',
	'facepalm' => '😑',
];
