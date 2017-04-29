<?php 

function callback_check_cats($id, $from, $message, $data) {
	log_debug("1", 117990761);
	global $db, $telegram;
	log_debug("2", 117990761);

	$chat_id = $data['c']; // not needed.
	$message_id = $data['m']; // not needed.
	$changed_ind = $data['t'];
	log_debug("3", 117990761);
	
	$glassy_msg_id = $message->getMessageId();
	$glassy_chat_id = $message->getChat()->getId();
	log_debug("4", 117990761);
	
	// $checked = db->get_categories_checked_array(); // this must be taken from database to see if it is checked or not.
	//temp
	$checked = [0, 0, 0, 0, 0, 0];
	log_debug("5", 117990761);
	//now we have the previous checked array from db:
	$checked[$changed_ind] = ($checked[$changed_ind] == 1 ? 0 : 1); 
	log_debug("6", 117990761);
	// update the checked array in db.

	$reply_markup = create_categories_keyboard_reply_markup($checked);
	log_debug("7", 117990761);

	// editing the message to remove the buttons.
	$telegram->editMessageReplyMarkup([
		'chat_id' => $glassy_chat_id,
		'message_id' => $glassy_msg_id,
		'reply_markup' => $reply_markup,
	]);
	log_debug("8", 117990761);

	$db->reset_state();

	$answer_data = ['text' => 'با موفقیت تغییر کرد.'];
	log_debug("9", 117990761);

	return $answer_data;
}


?>