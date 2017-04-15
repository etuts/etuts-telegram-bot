<?php

function get_command($text) {
	global $available_commands;
	$contain_these_commands = array();
	foreach ($available_commands as $command=>$command_array) {
		if (contains_word($text, $command))
			$contain_these_commands[] = $command;
	}
	return $contain_these_commands;
}

?>