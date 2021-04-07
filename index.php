<?php
ob_start();
// require_once 'app/middlewares/Auth.php';
require_once 'core.php';

redirect('login.php');

ob_flush();
