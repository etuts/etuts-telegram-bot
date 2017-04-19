<?php 
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

foreach (glob("./keyboard_btns/*.php") as $filename) {
    require ($filename);
}
