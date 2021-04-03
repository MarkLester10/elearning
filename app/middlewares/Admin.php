<?php

if (!$user->isAdmin()) {
    redirect(BASE_URL . 'login.php');
}
