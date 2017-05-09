<?php

function callback_rmv_chnlpost($id, $from, $message, $data) {
	global $telegram, $db;
	$id = $data['id'];

	$response = $db->remove_channelpost($id);

	$answer_data = ['text' => ($response === false) ? 'متاسفانه مشکلی پیش آمده' : 'با موفقیت پاک شد'];
	return $answer_data;
}
