<?php

if (!$user->isFaculty()) {
    redirect(BASE_URL . 'login.php');
}
