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