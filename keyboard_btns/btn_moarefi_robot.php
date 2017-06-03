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

			$params = [
				'post_format' => 'aside',
				'category' => [784, 615, 620, 623], /* [وب, ابزارها, تلگرام, ربات]*/
				'bot_id' => $data['bot_id'],
				'status' => 'publish',
			];
			send_post_to_site($title, $description, 1, $photo_link, $params);

			reset_state(THANK_MESSAGE);
			break;
		case MOAREFI_ROBOT_CAPTION:
			$data = $db->get_data();

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
			$text = str_replace('@' , '' , $text);
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
