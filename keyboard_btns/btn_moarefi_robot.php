<?php 

function btn_moarefi_robot($chat_id, $text, $message_id, $message, $state) {
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT_SCHEDULE_POST:
			$data = json_decode($db->get_data(), true);
			$image = $message->getPhoto();

			$final_text = make_post_moarefi_robot_for_channel($data['bot_id'], $image, $data['title'], $data['description']);
			$file = new Posts_file();
			$file->add_post($final_text);

			$db->reset_state();
			send_thank_message($message_id);
			break;
		case MOAREFI_ROBOT_BOT_IMAGE:
			$data = json_decode($db->get_data(), true);
			$data['description'] = $text;
			$db->set_data(json_encode($data));

			reply('اگر برای معرفی این ربات عکسی دارید بفرستید وگرنه عبارت no را تایپ کنید', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_SCHEDULE_POST);
			break;
		case MOAREFI_ROBOT_BOT_DESCRIPTION:
			$data = json_decode($db->get_data(), true);
			$data['bot_id'] = $text;
			$db->set_data(json_encode($data));
			/*$file = new Posts_file();
			$file->add_post($post_line);*/

			reply('توضیحات مربوط به ربات رو وارد کنید', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_BOT_IMAGE);
			break;
		case MOAREFI_ROBOT_BOT_ID:
			$data['title'] = $text;
			$db->set_data(json_encode($data));

			reply('آی دی ربات رو با @ وارد کن', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_BOT_DESCRIPTION);
			break;
		
		default:
			reply('عنوان وارد کن', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_BOT_ID);
			break;
	}
}

function make_post_moarefi_robot_for_channel($bot_id, $bot_image, $title, $description) {
	$final_text = $title . "\n" .
					$bot_id . "\n" .
					$description . "\n" .
					"@etuts";
	log_debug($final_text);
	return $final_text;
}