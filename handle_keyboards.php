<?php 
$keyboard_buttons = [

	"schedule_post"=>[
		"moarefi_robot" => array("name"=>'معرفی ربات', "permission"=>ADMIN)

	],
	"start"=>[
		"contact"=>array("name"=>"contact", "permission"=>USER),
		"help"=>array("name"=>"help", "permission"=>USER),
		"post_valiation"=>array("name"=>"post_validation", "permission"=>AUTHOR),
		"schedule_post"=>array("name"=>"schedule_post", "permission"=>ADMIN),

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
