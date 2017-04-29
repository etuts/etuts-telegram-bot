<?php 

function callback_chck_cats($id, $from, $message, $data) {
	global $db, $telegram;

	$chat_id = $data['c']; // not needed.
	$message_id = $data['m']; // not needed.
	$changed_ind = $data['t'];
	
	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	
	$checked = $db->get_categories_checked_array();
	//now we have the previous checked array from db:
	$checked[$changed_ind] = ($checked[$changed_ind] == 1 ? 0 : 1); 
	// update the checked array in db.
	$db->set_categories_checked_array($checked);

	$reply_markup = create_categories_keyboard_reply_markup($checked, $chat_id, $message_id);

	// editing the message to remove the buttons.
	$telegram->editMessageReplyMarkup([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'reply_markup' => $reply_markup,
	]);

	$db->reset_state();

	$answer_data = ['text' => 'با موفقیت تغییر کرد.'];

	return $answer_data;
}


?>