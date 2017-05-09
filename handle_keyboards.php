<?php 
$keyboard_buttons = [

	"schedule_post"=>[
		"moarefi_robot" => array("name"=>'معرفی ربات', "permission"=>ADMIN),
	],

	"start"=>[
		"contact"=>array("name"=>"تماس با ما", "permission"=>USER),
		"post_validation"=>array("name"=>"تایید مطلب توسط مدیر برای نوشتن", "permission"=>AUTHOR),
		"schedule_post"=>array("name"=>"ارسال مطلب به کانال", "permission"=>ADMIN),
		"request_post"=>array("name"=>"درخواست مطلب آموزشی", "permission"=>USER),
		"categories"=>array("name"=>"دریافت مطالب سایت", "permission"=>USER),
		"remove_last_channelpost"=>array("name"=>"حذف آخرین مطلب زمان بندی شده کانال", "permission"=>ADMIN),
		"post_source"=>array("name"=>"پیشنهاد مطلب به نویسنده ها", "permission"=>ADMIN),
		"get_site_recommend_post"=>array("name"=>"مطلب برای نوشتن تو سایت", "permission"=>AUTHOR),
		"manage_channel_posts"=>array("name"=>"مدیریت مطالب زمانبندی شده کانال", "permission"=>ADMIN),
	],

];

function run_keyboard_button($text, $chat_id, $message_id, $message) {
	global $keyboard_buttons;
	
	foreach ($keyboard_buttons as $keyboard_name => $btns) {
		foreach ($btns as $btn_name=>$btn ){
			
			if ($text == $btn['name']) {
				$func = 'btn_' . $btn_name;
				$func($chat_id, $text, $message_id, $message, IDLE);
				return true;
			}
		}
	}
	
	return false;
}

foreach (glob("./keyboard_btns/btn_*.php") as $filename) {
    require ($filename);
}
