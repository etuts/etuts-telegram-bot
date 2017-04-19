<?php 

function keyboard_button_lubtdbfhj($btn, $text, $chat_id, $message_id, $message) { // معرفی ربات
	// should read a file where we store all the posts in there
	global $db;
	reply($chat_id, 'عنوان وارد کن', true);
	$db->set_state(MOAREFI_ROBOT);
}
