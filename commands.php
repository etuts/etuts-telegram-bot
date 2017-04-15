<?php 

$available_commands = [

	"/contact" => array("name"=>"contact", "description"=>"description of contact"),

	"/post_validation" => array("name"=>"post_validation", "description"=>"description of post_validation"),
	
	"/cancel" => array("name"=>"cancel", "description"=>"description of cancel"),

	"/schedule_post" => array("name"=>"schedule_post", "description"=>"description of schedule_post"),

	"/start" => array("name"=>"start", "description"=>"description of start"),

	"/help" => array("name"=>"help", "description"=>"description of help")

];

foreach (glob("./commands/*.php") as $filename) {
    require ($filename);
}

?>


