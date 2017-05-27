<?php 

function btn_moarefi_robot($chat_id, $text, $message_id, $message, $state) {
	global $db;
	switch ($state) {
		case MOAREFI_ROBOT_SCHEDULE_POST:
			$data = $db->get_data();

			$title = $data['title'];
			$image_file_id = $data['image_file_id'];
			$description = $data['description'];
			$photo_link = get_file_link($image_file_id);

			$photo_link = send_post_to_site($title, $description, 1, $photo_link, ['post_format'=>'aside']);

			$final_text = make_post_moarefi_robot_for_channel($title, $photo_link, $description);
			$db->add_channelpost($final_text);

			reset_state(THANK_MESSAGE);
			break;
		case MOAREFI_ROBOT_CAPTION:
			$data = $db->get_data();

			/*$len_text = $data['title'] + strlen($text) + 2 + strlen("@etuts #bot");
			if ($len_text > 200) {
				reply('طول کپشن عکس برابر '. $len_text .' کارکتر است که از 200 کارکتر بیشتر است! لطفا یک کپشن دیگر وارد کنید.', true);
				break;
			}*/

			$data['description'] = $text;
			$db->set_data($data);

			btn_moarefi_robot($chat_id, $text, $message_id, $message, MOAREFI_ROBOT_SCHEDULE_POST);
			break;
		case MOAREFI_ROBOT_BOT_IMAGE:
			$data = $db->get_data();
			if ($message->isType('photo')) {
				$bot_image = $message->getPhoto();
				$data['image_file_id'] = ($bot_image)[count($bot_image)-1]['file_id'];
				reply('لطفا کپشن عکس را وارد کنید', true);
				$db->set_data($data);
				$db->set_state(MOAREFI_ROBOT_CAPTION);
				break;
			} //else {
			reply(emoji('alert') . 'عکس بفرست لطفا!!');

			break;
		case MOAREFI_ROBOT_BOT_ID:
			$data = $db->get_data();
			$data['bot_id'] = $text;
			$db->set_data($data);

			reply('حالا عکسش رو بفرست', true);
			$db->set_state(MOAREFI_ROBOT_BOT_IMAGE);
			break;

		case MOAREFI_ROBOT_BOT_TITLE:
			$data['title'] = emoji('robot') . ' ' . $text;
			$db->set_data($data);

			reply('آی دی ربات رو با @ وارد کن', true);
			$db->set_state(MOAREFI_ROBOT_BOT_ID);
			break;
		
		default:
			reply('عنوان وارد کن', true);
			$db->set_state(MOAREFI_ROBOT_BOT_TITLE);
			break;
	}
}

function make_post_moarefi_robot_for_channel($title, $bot_image, $description) {
	$text = '[‍ ](' . $bot_image . ')' . $title . "\n" .
			$description . "\n" .
			"@etuts #bot";
	
	$final_text = [
		'type' => 'text',
		'text' => $text,
	];
	return addslashes(json_encode($final_text));
}
