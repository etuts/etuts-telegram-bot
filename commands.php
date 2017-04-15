<?php 
$available_commands = ['/contact','/post_validation','/cancel','/schedule_post','/start','/help'];

foreach (glob("./commands/*.php") as $filename) {
    require ($filename);
}

?>