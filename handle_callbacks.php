<?php 

$callback_query_functions = [

	"admn_answr_cntct",
	"rqst_acc_dny",
	"pst_vldshn",
	"chck_cats",

];

function run_callback_queries($id, $from, $message, $data) {
	global $callback_query_functions, $telegram;
	$data = json_decode($data, true);
	$callback_func = $data['f'];

	if (in_array($callback_func, $callback_query_functions)) {
		$func = 'callback_' . $callback_func;
		unset($data['f']);
		$answer_data = $func($id, $from, $message, $data);

		$answer_data['callback_query_id'] = $id;
		$telegram->answerCallbackQuery($answer_data);
	}
}

foreach (glob("./callbackqueries/callback_*.php") as $filename) {
    require ($filename);
}
