<?php 
$keyboard_buttons = [

	"moarefi_robot" => array("name"=>'معرفی ربات', "permission"=>ADMIN),

];

function run_keyboard_buttons($text, $chat_id, $message_id, $message) {
	global $keyboard_buttons;
	
	foreach ($keyboard_buttons as $func_name => $btn) {
		if ($text == $btn['name']) {
			$func = 'btn_' . $func_name;
			$func($btn, $text, $chat_id, $message_id, $message);
			return true;
		}
	}
	
	return false;
}

foreach (glob("./keyboard_btns/*.php") as $filename) {
    require ($filename);
}
