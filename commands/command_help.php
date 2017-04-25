<?php
	function getFile(array $params)
    {
        $response = $this->post('getFile', $params);
        return new File($response->getDecodedBody());
    }
	function getUserProfilePhotos(array $params)
    {
        $response = $this->post('getUserProfilePhotos', $params);
        return new UserProfilePhotos($response->getDecodedBody());
    }
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
	$params =['user_id' => $chat_id];
	$photos = $telegram->getUserProfilePhotos($params);
	$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => "test",
		]);
	$photo = $photos[0][0];
	if ($photo != null){
		$file = $telegram->getFile($photo->file_id);
		$telegram->sendMessage([
		'chat_id' => $chat_id,
		'text' => $file->file_path,
		]);
	}
	



}
