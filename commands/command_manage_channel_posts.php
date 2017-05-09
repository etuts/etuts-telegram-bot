<?php 

function run_manage_channel_posts_command($chat_id, $text, $message_id, $message, $state) {
	global $db, $telegram;
	$channelposts = $db->get_channelposts();
	$btns = array();
	foreach ($channelposts as $id => $data) {
		$btns[] = create_glassy_btn($data, 'rmv_chnlpost', ['id' => $id]);
	}
	$keyboard = array_duplex($btns);
	$reply_markup = create_glassy_keyboard($keyboard);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => 'در اینجا لیست تمام مطالبی که برای ارسال در کانال زمان بندی شده اند را مشاهده می کنید. شما با انتخاب هر کدام از این مطالب، آن را از دیتابیس حذف خواهید کرد',
		'reply_markup' => $reply_markup,
	]);
	send_thank_message();
}
