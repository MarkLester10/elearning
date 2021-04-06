<?php
require_once('app/database/Database.php');
require('app/config/Config.php');
require('app/helpers/kernel.php');
require_once('app/controllers/Controllers.php');
require_once('app/models/User.php');
date_default_timezone_set('Asia/Singapore');



// start session
session_start();

function dump($value) // to be deleted soon

{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

// instantiate user model
$user = new User();

// // Turn off all error reporting
// error_reporting(0);
    // instantiate middlewares