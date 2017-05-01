<?php 
function contains_word($source, $find) {
	if (strpos($source, $find) !== false)
		return true;
	return false;
}
function convert_to_english($text) {
	$persian = array('ض','ص','ث','ق','ف','غ','ع','ه','خ','ح','ج','چ','ش','س','ی','ب','ل','ا','ت','ن','م','ک','گ','ظ','ط','ز','ر','ذ','د','پ','و',' ');
	$english = array('q','w','e','r','t','y','u','i','o','p','_1','_2','a','s','d','f','g','h','j','k','l','_3','_4','z','x','cv','b','n','m','_5','_');
	return str_replace($persian, $english, $text);
}
// araye intory bar migardoone:     [["0", "1"]
//                                  ["2", "3"]] ...
function array_duplex($arr){
    $ans = array();
    $cnt = 0;
    $i = -1;
    
    foreach($arr as $ind){
        if($cnt%2 == 0){
            $i++;
            array_push($ans, array());
        }

        array_push($ans[$i], $ind);
        $cnt++; 
    }
    
    return $ans;
}
function emoji($text){
    $emoji = [
        'laugh' => '😂',
        'poker' => '😐',
        ':D' => '😁',
        'thinking' => '🤔',
        'like' => '👍',
        'exact' => '👌',
        'hand' => '✋',
        'facepalm' => '😑',
        'dislike' => '👎',
        'image-icon' => '🖼',
        'game' => '🎮',
        'desktop' => '🖥',
        'electricity' => '💡',
        'mobile' => '📱',
        'web' => '🌎',
        'design' => '🎨',
        'checked' => '✅',
        'not_checked' => '◻️'
    ];
    return $emoji[$text];
}

// post display functions
function get_last_post(){
    file_put_contents("feed", fopen("http://etuts.ir/feed", 'r'));
    $rss = simplexml_load_file('feed');
    $last_item = $rss->channel->item;
    return $last_item;
}
function get_last_topic(){
	file_put_contents("feed", fopen("http://etuts.ir/topics/feed", 'r'));
	$rss = simplexml_load_file('feed');
	$last_item = $rss->channel->item;
	return $last_item;
}
function make_post_for_channel($title, $description, $image_link = false, $link_to_site = false) {
    
    $image_link = ($image_link === false) ? '' : "[".emoji('image-icon')."](".$image_link.")";

    $link_to_site = ($link_to_site === false) ? '' : "[برای مشاهده ی مطلب کلیک کنید](".$link_to_site.")";

    $final_text =   $title.$image_link."\n".
                    $description."\n".
                    $link_to_site."\n".
                    "@etuts";
}
function display_latest_post($chat_id) {
    global $telegram;
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
    $final_text = "Debug ";
    $final_text .= make_post_for_channel($title, $description, $image_link, $link_to_site);

    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $final_text,
        'parse_mode' => "Markdown",
    ]);
}

$categories_array = [
    ['emoji'=>'game', 'name'=>'بازی'], 
    ['emoji'=>'electricity', 'name'=>'برق'], 
    ['emoji'=>'desktop', 'name'=>'دسکتاپ'], 
    ['emoji'=>'design', 'name'=>'طراحی'], 
    ['emoji'=>'mobile', 'name'=>'موبایل'], 
    ['emoji'=>'web', 'name'=>'وب'], 
];

$lots_of_dots = str_repeat('.', 100);


function create_categories_keyboard_reply_markup($checked, $chat_id, $message_id){
    global $categories_array, $lots_of_dots;
    $btns = [];
    foreach($categories_array as $num => $category){
        $txt = emoji($checked[$num] ? 'checked':'not_checked') . '. ' . emoji($category["emoji"]) . ' ' . $category["name"] . $lots_of_dots;
        $btns[] = [create_glassy_btn($txt , 'chck_cats', $chat_id, $message_id, '"t":'.$num)];
    }
    return create_glassy_keyboard($btns);
}