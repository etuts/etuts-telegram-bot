<?php 

function callback_check_cats($id, $from, $message, $data) {
	global $db, $telegram, $lots_of_dots, $categories_array;
	$chat_id = $data['c']; // not needed.
	$message_id = $data['m']; // not needed.
	$changed_ind = $data['t'];
	
	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	
	// $checked = db->get_categories_checked_array(); // this must be taken from database to see if it is checked or not.
	//temp
	$checked = [0, 0, 0, 0, 0, 0];
	//now we have the previous checked array from db:
	$checked[$changed_ind] = ($checked[$changed_ind] == 1 ? 0 : 1); 
	// update the checked array in db.

	$reply_markup = create_categories_keyboard_reply_markup($checked);

	// editing the message to remove the buttons.
	$telegram->editMessageReplyMarkup([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'reply_markup' => $reply_markup,
	]);

	$db->reset_state();

	return $answer_data;
}


?>