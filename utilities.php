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
    ];
    return $emojis[$text];
}
function get_last_post(){
    file_put_contents("feed", fopen("http://etuts.ir/feed", 'r'));
    $rss = simplexml_load_file('feed');
    $last_item = $rss->channel->item;
    return $last_item;
}
function display_latest_post_in_channel() {
    global $telegram;
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
    // $link_to_site = " ";
    $link_to_site = $post->link;
    $link_to_site = "[برای مشاهده ی مطلب کلیک کنید](".$link_to_site.")";
    $final_text = $post->title.$image_link."\n".$text."\n".$link_to_site;


    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $final_text,
        'parse_mode' => "Markdown",
    ]);
}
