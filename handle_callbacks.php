<?php 

$callback_query_functions = [

	"admin_answer_to_contact" => array("name"=>"contact", "permission"=>USER),
];

function run_callback_queries($id, $from, $message, $data) {
	global $callback_query_functions;
	$data = json_decode($data);
	$callback_func = $data['func'];

	if (in_array($callback_func, $callback_query_functions)) {
		$func = 'callback_' . $callback_func;
		unset($data['func']);
		$answer_data = $func($id, $from, $message, $data);

		$answer_data['callback_query_id'] = $id;
		$telegram->answerCallbackQuery($answer_data);
	}
}

foreach (glob("./callbackqueries/callback_*.php") as $filename) {
    require ($filename);
}
