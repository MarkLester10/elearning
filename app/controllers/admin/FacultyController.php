<?php
require_once '../../../core.php';


$result = array('error' => false);
$dept_id = '';


if (isset($_GET['dept_id'])) {
    $dept_id = $_GET['dept_id'];
}

//FETCH COMMENTS
if (!empty($dept_id)) {

    $sql = "SELECT * FROM subjects_schedule WHERE department_id=:id";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $dept_id);
    $run = $stmt->execute();
    $subjects = $stmt->fetchAll();
    if ($run) {
        $result['subjects'] = $subjects;
    }
}





echo json_encode($result);
