<?php
// start session
session_start();
require_once('app/database/database.php');
require('app/config/config.php');
require('app/helpers/kernel.php');
require_once('app/controllers/Controllers.php');
require_once('app/models/User.php');
date_default_timezone_set('Asia/Singapore');





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