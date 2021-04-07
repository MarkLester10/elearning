<?php

if (!$user->isMonitoringStaff()) {
    redirect(BASE_URL . 'login.php');
}
