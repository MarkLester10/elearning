<?php


if (!$user->isAdmin()) {
    redirect(BASE_URL . '404.php');
}
