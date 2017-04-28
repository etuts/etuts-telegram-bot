<?php 
$keyboard_buttons = [

	"schedule_post"=>[
		"moarefi_robot" => array("name"=>'معرفی ربات', "permission"=>ADMIN)

	],
	"start"=>[
		"contact"=>array("name"=>"تماس با ما", "permission"=>USER),
		// "help"=>array("name"=>"help", "permission"=>USER),
		"post_valiation"=>array("name"=>"تایید مطلب", "permission"=>AUTHOR),
		"schedule_post"=>array("name"=>"ارسال مطلب به کانال", "permission"=>ADMIN),
		"request_post"=>array("name"=>"درخواست مطلب آموزشی", "permission"=>USER),
	],

];

function run_keyboard_buttons($text, $chat_id, $message_id, $message) {
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
