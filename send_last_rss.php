#!/usr/bin/php
<?php 
/*
open a db that contains posts. each post on a line
send the post to channel (you may be able to require the codes of iraqsaqi (bayad beshe dige moshkeli nadare))
delete that line
*/

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/utilities.php';
require_once __DIR__.'/config.php';
use Telegram\Bot\Api;

require __DIR__.'/database_class.php';

$db = new Database($db_name, $db_user, $db_pass);
$telegram = new Api($token);
// display_latest_post(9778738);
$post = get_last_post();
$description = $post->description;
    $title = $post->title;

    //Getting image link from description 
    $text = "";
    $text .= $description;
    $pos = strpos($text, "src=\"") + 5;
    $text = substr($text,$pos);
    $pos2 = strpos($text, "\"");
    $image_link = substr($text,0,$pos2);

    $description = strip_tags($description);
    $description = substr($description, 0,strlen($description)-9);	//Removing garbage characters from description
    
    $link_to_site = $post->link;

    $final_text = make_post_for_channel($title, $description, $image_link, $link_to_site);

    $telegram->sendMessage([
        'chat_id' => 9778738,
        'text' => $final_text,
        'parse_mode' => "Markdown",
    ]);



// $post_data = $db->read_post();
// if ($post_data === false)
// 	die("no posts");

// $type = $post_data['type'];
// // echo "\n";
// // var_export($post_data);
// if ($type == '')
// 	die("no type");
// switch ($type) {
// 	case 'text':
// 		$telegram->sendMessage([
// 			'chat_id' => $post_data['chat_id'],
// 			'text' => $post_data['text'],
// 		]);
// 		break;
// 	case 'photo':
// 		$text = '';
// 		$caption = $post_data['caption'];
// 		if (strlen($caption) > 200) {
// 			$pos_of_third_line = strposX($caption, "\n", 2) +1;
// 			$text = substr($caption, $pos_of_third_line);
// 			$caption = substr($caption, 0, $pos_of_third_line);
// 		}
// 		$message = $telegram->sendPhoto([
// 			'chat_id' => $post_data['chat_id'],
// 			'photo' => $post_data['photo'],
// 			'caption' => $caption,
// 		]);
// 		if (strlen($text) != 0) {
// 			$telegram->sendPhoto([
// 				'chat_id' => $post_data['chat_id'],
// 				'text' => $text,
// 				'reply_to_message_id' => $message->getMessageId(),
// 			]);
// 		}
// 		break;
// }

// function strposX($haystack, $needle, $number){
//     if($number == '1'){
//         return strpos($haystack, $needle);
//     }elseif($number > '1'){
//         return strpos($haystack, $needle, strposX($haystack, $needle, $number - 1) + strlen($needle));
//     }else{
//         return error_log('Error: Value for parameter $number is out of range');
//     }
// }
