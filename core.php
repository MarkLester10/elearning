<?php
require_once('app/database/Database.php');
require('app/config/Config.php');
require('app/helpers/kernel.php');
require_once('app/controllers/Controllers.php');
require_once('app/models/User.php');




// start session
session_start();

// instantiate user model
$user = new User();
    // instantiate middlewares