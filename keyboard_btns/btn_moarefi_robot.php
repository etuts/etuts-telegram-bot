<?php 

function btn_moarefi_robot($chat_id, $text, $message_id, $message, $state) {
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT_SCHEDULE_POST:
			$data = $db->get_data();

			$image = ($message->isType('photo')) ? $message->getPhoto() : false;
			$final_text = make_post_moarefi_robot_for_channel($data['bot_id'], $image, $data['title'], $data['description']);
			$db->add_post($final_text);

			$db->reset_state();
			send_thank_message($message_id);
			break;
		case MOAREFI_ROBOT_BOT_IMAGE:
			// if (strlen($text))
			$data = $db->get_data();
			$data['description'] = $text;
			$db->set_data($data);

			reply('اگر برای معرفی این ربات عکسی دارید بفرستید وگرنه عبارت no را تایپ کنید', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_SCHEDULE_POST);
			break;
		case MOAREFI_ROBOT_BOT_DESCRIPTION:
			$data = $db->get_data();
			$data['bot_id'] = $text;

			$db->set_data($data);
			
			reply('توضیحات مربوط به ربات رو وارد کنید', $message_id, true);
			$db->set_state(MOAREFI_ROBOT_BOT_IMAGE);
			break;
		case MOAREFI_ROBOT_BOT_ID:
			$data['title'] = $text;
			$db->set_data($data);

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
	// $chat_id = get_chat_id();

	$text = $title . "\n" .
					$bot_id . "\n" .
					$description . "\n" .
					"@etuts" . "\n" .
					"#bot";
	
	if ($bot_image == false) {
		$final_text = [
			'type' => 'text',
			'chat_id' => 92454,
			'text' => $text,
		];
	} else {
		$len_text = strlen($text);
		if ($len_text > 200) {
			reply('طول کپشن عکس برابر '. $len_text .' کارکتر است که از ۲۰۰ کارکتر بیشتر است!');
		}
		$bot_image = $bot_image[count($bot_image)-1];	
		$final_text = [
			'type' => 'photo',
			'chat_id' => 92454,
			'photo' => $bot_image['file_id'],
			'caption' => $text,
		];
	}
	return addslashes(json_encode($final_text));
}
