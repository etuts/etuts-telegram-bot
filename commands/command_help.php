<?php

function run_help_command($chat_id, $text, $message_id, $message, $state) {
	global $telegram, $available_commands,$db;
	$is_admin =  $db->check_user_permission(ADMIN);
	$is_author = $db->check_user_permission(AUTHOR);
	$permission = $is_admin ? ADMIN : $is_author ? AUTHOR : USER;
	$answer = '';
	foreach ($available_commands as $command) {
		if ($command["permission"] <= $permission)
			$answer .= ("/".$command["name"]." - ".$command["description"]."\n");
	}
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $answer,
	]);
	$text = "";
    $post = get_last_post();
    $text .= $post->description;
    $pos = strpos($text, "src=\"") + 5;
    $text = substr($text,$pos);
    $pos2 = strpos($text, "\"");
    $link = substr($text,0,$pos2);
    $text = strip_tags($post->description);
    $text = substr($text, 0,strlen($text)-9);
    $image_link = "[".emoji('image-icon')."](".$link.")";
    $author = $post->creator;
    // $link_to_site = " ";
    $link_to_site = $post->link;
    $link_to_site = "[برای مشاهده ی مطلب کلیک کنید](".$link_to_site.")";
    $final_text = $post->title.$image_link."\n".$text."\n".$link_to_site."\n".$author;


    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $author,
        'parse_mode' => "Markdown",
    ]);
}
