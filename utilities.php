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
		'not_checked' => '◻️',
		'alert' => '⚠️',
		'robot' => '🤖',
	];
	return $emoji[$text];
}

$lots_of_dots = str_repeat('.', 100);
function create_categories_keyboard_reply_markup($checked){
	global $categories_array, $lots_of_dots;
	$btns = [];
	foreach($categories_array as $num => $category){
		$txt = emoji($checked[$num] ? 'checked':'not_checked') . '. ' . emoji($category["emoji"]) . ' ' . $category["name"] . $lots_of_dots;
		$btns[] = [create_glassy_btn($txt , 'chck_cats', ['t' => $num])];
	}
	return create_glassy_keyboard($btns);
}

function create_about_us_keyboard_reply_markup(){
	global $lots_of_dots;
	$btns = [];
	$vahid = "وحید محمدی";
	$url_vahid = "http://github.com/gvmohzibat";
	$mamad = "محمد فغان‌پور گنجی";
	$url_mamad = "https://github.com/MohGanji";
	$shahr = "شهریار سلطان‌پور";
	$url_shahr = "https://github.com/sh-soltanpour";
	$btns[] = [create_glassy_link_btn($vahid, $url_vahid)];
	$btns[] = [create_glassy_link_btn($mamad, $url_mamad)];
	$btns[] = [create_glassy_link_btn($shahr, $url_shahr)];

	return create_glassy_keyboard($btns);
}

function send_post_to_site($post_title, $post_content, $author_id, $featured_image_link, $params) {
	/*	params = [
	*		post_type
	*		post_format
	* 	]
	*/

	$new_post_url = 'http://etuts.ir/new-post';

	// default values for optional params
	$params = array_merge(array(
		'post_type' => 'post',
		'post_format' => 'standard',
	), $params);

	// Initialize Guzzle client
	$client = new GuzzleHttp\Client();

	// Create a POST request
	$response = $client->request(
		'POST',
		$new_post_url,
		[
			'form_params' => [
				'submit' => 'submit',
				'title' => $post_title,
				'content' => $post_content,
				'wp_post_type' => $params['post_type'],
				'author' => $author_id,
				'wp_post_format' => $params['post_format'],
				'wp_post_featured_image' => $featured_image_link,
			]
		]
	);
	// Parse the response object, e.g. read the headers, body, etc.
	$featured_image_link = $response->getHeaders()['featured_image_link'][0];
	return $featured_image_link;
}
