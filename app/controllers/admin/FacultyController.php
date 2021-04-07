<?php
require_once '../../../core.php';


$result = array('error' => false);
$dept_id = '';
$faculty_id = '';


if (isset($_GET['dept_id'])) {
    $dept_id = $_GET['dept_id'];
}
if (isset($_GET['faculty_id'])) {
    $faculty_id  = $_GET['faculty_id'];
}


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
//FETCH CLASSES
if (!empty($faculty_id)) {
    $sql = "SELECT * FROM rooms WHERE user_id=:id";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $faculty_id);
    $run = $stmt->execute();
    $classes = $stmt->fetchAll();
    if ($run) {
        // print_r($classes);
        // die();
        $result['classes'] = $classes;
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'add_class') {

    $data = [
        'department_id' => $_POST['department_id'],
        'subject_schedule_id' => $_POST['subject_schedule_id'],
        'google_meet_link' => $_POST['google_meet_link'],
        'faculty_id' => $_POST['faculty_id']
    ];
    $result['data'] = $data;

    $sql = "SELECT * FROM departments WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $data['department_id']]);
    $department = $stmt->fetch();

    $sql = "SELECT * FROM subjects_schedule WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $data['subject_schedule_id']]);
    $subject = $stmt->fetch();

    // $department = $this->getDepartment($this->data['department_id']);
    // $subject = $this->getSubject(($this->data['subject_schedule_id']));
    $subject_name = $department->name . '/' . $subject->subject_code . '/' . $subject->subject_name . '/' . $subject->schedule;
    $department_id = $data['department_id'];
    $subject_schedule_id = $data['subject_schedule_id'];
    $google_meet_link = $data['google_meet_link'];
    $user_id = $data['faculty_id'];

    // check if may existing scheduled class
    $sql = "SELECT * FROM rooms WHERE subject_name=:subject_name LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':subject_name', $subject_name);
    $stmt->execute();
    $class = $stmt->fetch();
    if ($class) {
        $result['is_created'] = 1;
    } else {
        $sql = "INSERT INTO rooms (department_id, subject_schedule_id, subject_name, google_meet_link, user_id )
        VALUES (:department_id, :subject_schedule_id, :subject_name, :google_meet_link, :user_id)";
        $stmt = $conn->prepare($sql);
        $run = $stmt->execute([
            'department_id' => $department_id,
            'subject_schedule_id' => $subject_schedule_id,
            'subject_name' => $subject_name,
            'google_meet_link' => $google_meet_link,
            'user_id' => $user_id,
        ]);

        //department_id	subject_schedule_id	subject_name	google_meet_link	user_id	created_at
        if ($run) {
            $result['message'] = "Room Successfully Created";
        }
    }
}

echo json_encode($result);
