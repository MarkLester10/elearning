<?php

if (!$user->isMonitoringStaff()) {
    redirect(BASE_URL . '404.php');
}
