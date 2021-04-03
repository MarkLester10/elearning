<?php
if (!isset($_SESSION['id'])) {
    redirect(BASE_URL . 'login.php');
}
