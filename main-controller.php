<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//--------------------- Enum of permissions ----------------------
define("USER", 0);
define("ADMIN", 1);
define("AUTHOR", 2);
//--------------------- Enum of site recommended posts states ----
define("NOT_RESERVED", 0);
define("RESERVED", 1);

//--------------------- database class ---------------------------
require('database_class.php');

//--------------------- database functions -----------------------
require('handle_state.php');

//--------------------- telegram keyboard buttons functions ------
require('handle_keyboards.php');

//--------------------- telegram command functions ---------------
require('handle_commands.php');

//--------------------- telegram callback queries functions ------
require('handle_callbacks.php');

//--------------------- telegram bot api helper functions --------
require('telegram_helpers.php');

//--------------------- php helpers ------------------------------
require('utilities.php');
