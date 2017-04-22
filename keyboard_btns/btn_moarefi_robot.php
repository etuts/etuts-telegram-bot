<?php 

function btn_moarefi_robot($chat_id, $text, $message_id, $message, $state) {
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT:
			$file = new Posts_file();
			$post_line = $text;
			$file->add_post($post_line);
			log_debug("ok");
			// $db->reset_state();
			break;
		
		default:
			reply('عنوان وارد کن', $message_id, true);
			$db->set_state(MOAREFI_ROBOT);
			break;
	}
}
