<?php
if (isset($_SESSION['id'])) {
    if ($user->isAdmin()) {
        redirect('admin/dashboard.php');
    } elseif ($user->isFaculty()) {
        redirect('admin/faculty_dashboard.php');
    } elseif ($user->isMonitoringStaff()) {
        redirect('admin/monitoring_dashboard.php');
    }
    exit();
}
