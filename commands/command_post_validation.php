<?php

function run_post_validation_command($chat_id, $text, $message_id, $message) {
	global $telegram, $db;
	if ($db->check_user_permission(AUTHOR) || $db->check_user_permission(ADMIN)) {
		$db->set_state(POST_VALIDATION_SEND_POST_TITLE);
		$answer = 'عنوان مطلب و لینک مطلبی که می خواهید بنویسید را وارد کنید';
		$reply_markup = $telegram->forceReply();
	} else {
		$answer = 'ببخشید اما شما نویسنده ی سایت نیستید!';
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
		'reply_to_message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}

?>