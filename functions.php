<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//--------------------- Enum of permissions ----------------------
define("ADMIN", 1);
define("AUTHOR", 2);

//--------------------- Enum of STATEs ---------------------------
define("IDLE", 0);
define("CONTACT", 1);
define("POST_VALIDATION_SEND_POST_TITLE", 2);
define("MOAREFI_ROBOT", 3);

//--------------------- database class ---------------------------
require('database_class.php');

//--------------------- posts_file class -------------------------
require('posts_file_class.php');

//--------------------- database functions -----------------------
require('database_functions.php');

//--------------------- telegram keyboard buttons functions ------
require('keyboard_buttons.php');

//--------------------- telegram command functions ---------------
require('commands.php');

//--------------------- telegram bot api helper functions --------
require('telegram_helpers.php');

//--------------------- php helpers ------------------------------
require('php_helpers.php');

?>
