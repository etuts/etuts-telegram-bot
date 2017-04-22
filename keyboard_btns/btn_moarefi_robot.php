<?php 

function btn_moarefi_robot($chat_id, $text, $message_id, $message, $state) {
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT:
			$post_line = $text;
			log_debug("vahid");

			/*$file = new Posts_file();
			$file->add_post($post_line);*/
			/*$file = fopen("channel-posts.txt", "w");
			fwrite($file, $post_line . PHP_EOL);*/
			$myfile = fopen("logs.txt", "a") or die("Unable to open file!");
			$txt = "user id date";
			fwrite($myfile, "\n". $txt);
			fclose($myfile);
			$db->reset_state();
			break;
		
		default:
			reply('عنوان وارد کن', $message_id, true);
			$db->set_state(MOAREFI_ROBOT);
			break;
	}
}
