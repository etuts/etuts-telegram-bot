<?php 

function btn_moarefi_robot($btn, $text, $chat_id, $message_id, $message, $state) {
	// should read a file where we store all the posts in there
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT:
			$file = new Posts_file();
			$post_line = $text;
			$file->add_post($post_line);
			break;
		
		default:
			reply('عنوان وارد کن', $message_id, true);
			$db->set_state(MOAREFI_ROBOT);
			break;
	}
}
