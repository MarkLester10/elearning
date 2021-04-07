<?php
class Monitor extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id)
    {
        $sql = "SELECT * FROM users WHERE position_id=2 AND department_id='$id' ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getDepartments()
    {
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM departments";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getRooms($id)
    {
        $sql = "SELECT * FROM rooms WHERE user_id=$id";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getRoom($id)
    {
        $sql = "SELECT * FROM rooms WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return  $stmt->fetch();
    }

    public function getClassesById($user_id)
    {
        $sql = "SELECT * FROM classes WHERE user_id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        return $stmt->fetchAll();
    }
    public function getClassesByRoomId($room_id)
    {
        $sql = "SELECT * FROM classes WHERE room_id=:id AND start_time IS NOT NULL AND duration IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $room_id]);
        return $stmt->fetchAll();
    }
    public function getResults()
    {
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM classes WHERE end_time IS NOT NULL AND user_id = $id ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }


    public function create($data)
    {
        $this->data = $data;
        $this->validate();
        $this->checkIfHasError();
    }
    //Error handling
    // Validate category name
    public function validate()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field must not be empty");
                return;
            }

            // $this->validateDepartmentName();

            return $this->errors;
        }
    }

    private function validateDepartmentName()
    {
        // check if empty
        $val = $this->data['name'];
        if (empty($val)) {
            $this->addError('name', 'Department name must not be empty');
        }
    }
    //add error

    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    public function getSubject($id)
    {
        $sql = "SELECT * FROM subjects_schedule WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    //Check if no more errors then insert data
    private function checkIfHasError()
    {
        if (!array_filter($this->errors)) {
            $department = $this->getDepartment($this->data['department_id']);
            $subject = $this->getSubject(($this->data['subject_schedule_id']));
            $scheduled_class = $department->name . '-' . $subject->subject_name . '-' . $subject->schedule;
            $department_id = $this->data['department_id'];
            $subject_schedule_id = $this->data['subject_schedule_id'];
            $google_meet_link = $this->data['google_meet_link'];
            $user_id = $_SESSION['id'];

            // check if may existing scheduled class
            $sql = "SELECT * FROM classes WHERE scheduled_class=:scheduled_class LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':scheduled_class', $scheduled_class);
            $stmt->execute();
            $class = $stmt->fetch();
            if ($class) {


                redirect('faculty_dashboard.php');
                // die();
            } else {
                $sql = "INSERT INTO classes (department_id, scheduled_class, subject_schedule_id, google_meet_link, user_id )
                VALUES (:department_id, :scheduled_class, :subject_schedule_id, :google_meet_link, :user_id)";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'department_id' => $department_id,
                    'scheduled_class' => $scheduled_class,
                    'subject_schedule_id' => $subject_schedule_id,
                    'google_meet_link' => $google_meet_link,
                    'user_id' => $user_id,
                ]);
                if ($run) {
                    $_SESSION['message'] = 'A class has been created';
                    $_SESSION['type'] = 'success';
                    redirect('faculty_dashboard.php');
                }
            }
        }
    }

    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM classes WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'A class has been deleted';
            redirect('faculty_dashboard.php');
        } else {
            // $_SESSION['danger'] = 'A class cannot be deleted because of associated data';
            $_SESSION['type'] = 'error';
            $_SESSION['message'] = 'A class cannot be deleted because of associated data';
            redirect('faculty_dashboard.php');
        }
    }
    // get single department
    public function getDepartment($id)
    {
        $sql = "SELECT * FROM departments WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $department = $stmt->fetch();
        return $department;
    }
    public function getClass($id)
    {
        $sql = "SELECT * FROM classes WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return  $stmt->fetch();
    }
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }



    //update category
    public function update($data)
    {
        $this->data = $data;
        $this->validate();
        $this->updateDepartment();
    }
    private function updateDepartment()
    {
        $name = $this->data['name'];
        $id = $this->data['id'];
        if (!array_filter($this->errors)) {
            $sql = "UPDATE departments set name=:name WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $updated = $stmt->execute(['name' => $name, 'id' => $id]);
            if ($updated) {
                message('success', 'A department has been updated');
                redirect('departments.php');
            }
        }
    }


    public function updateClass($data, $files)
    {
        $current_user = $_SESSION['id'];
        $current_class = $data['id'];
        $start_time = date('Y-m-d H:i:s');
        $newImageName = '';
        $run = '';
        if ($files) {
            $newImageName =  $files['screen_shot']['name'];
            $tmpName = $files['screen_shot']['tmp_name'];
            $targetDirectory = ROOT_PATH . "/assets/imgs/screenshots/" .  $newImageName;
            move_uploaded_file($tmpName, $targetDirectory);
            $sql = "UPDATE classes set start_time=:start_time, is_sent_to_monitoring=:is_sent_to_monitoring, screen_shot=:screen_shot WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'start_time' => $start_time,
                'is_sent_to_monitoring' => 1,
                'screen_shot' => $newImageName,
                'id' => $current_class,
            ]);
            if ($run) {
                $sql = "UPDATE users set is_sent_to_monitoring=:is_sent_to_monitoring WHERE id=:user_id ";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'is_sent_to_monitoring' => 1,
                    'user_id' => $current_user,
                ]);
            }
        } else {
            $sql = "UPDATE classes set start_time=:start_time, is_sent_to_monitoring=:is_sent_to_monitoring WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'start_time' => $start_time,
                'is_sent_to_monitoring' => 1,
                'id' => $current_class,
            ]);
            if ($run) {
                $sql = "UPDATE users set is_sent_to_monitoring=:is_sent_to_monitoring WHERE id=:user_id ";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'is_sent_to_monitoring' => 1,
                    'user_id' => $current_user,
                ]);
            }
        }

        if ($run) {
            redirect('class.php?id=' . $current_class);
        }
    }

    private function move_file()
    {
    }

    public function updateEndClass($data)
    {

        $current_class = $data['id'];
        $activeClass = $this->getClass($current_class);
        $end_time = date('Y-m-d H:i:s');
        $duration = calculateDuration($activeClass->start_time, $end_time);
        //2016-06-01 22:45:00
        // 2021-04-04 16:34:37
        $final_duration = $duration[0] . ':' . $duration[1] . ':' . $duration[2];


        $sql = "UPDATE classes SET end_time=:end_time, duration=:duration  WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $run = $stmt->execute([
            'end_time' => $end_time,
            'duration' => $final_duration,
            'id' => $current_class,
        ]);
        if ($run) {
            redirect('class.php?id=' . $current_class);
        }
    }

    public function updateClassMonitorStatus($data)
    {
        // update is_monitored users table
        // update monitoring_id and is_monitored sa classes table
        $class_id = $data['class_id'];
        $faculty_id = $data['faculty_id'];
        $room_id = $data['room_id'];


        $sql = "UPDATE users SET is_monitored=:is_monitored WHERE id=:user_id";
        $stmt = $this->conn->prepare($sql);
        $run = $stmt->execute([
            'is_monitored' => 1,
            'user_id' => $faculty_id,
        ]);
        if ($run) {
            $sql = "UPDATE classes SET monitoring_id=:monitoring_id, is_monitored=:is_monitored WHERE id=:class_id";
            $stmt = $this->conn->prepare($sql);
            $updated = $stmt->execute([
                'monitoring_id' => $_SESSION['id'],
                'is_monitored' => 1,
                'class_id' => $class_id,
            ]);
            if ($updated) {
                redirect("monitoring_class_detail.php?class_id=$class_id&user_id=$faculty_id&room_id=$room_id");
            }
        }
    }


    public function endClassMonitoring($data)
    {
        // update is_monitored users table
        // update monitoring_id and is_monitored sa classes table
        $class_id = $data['class_id'];
        $user_id = $data['user_id'];

        $activeClass = $this->getClass($class_id);
        if (is_null($activeClass->duration)) {
            $updateTime = $this->updateClassMonitoringDuration($activeClass);
            if ($updateTime) {
                $sql = "UPDATE users SET is_monitored=:is_monitored, is_sent_to_monitoring=:is_sent_to_monitoring WHERE id=:user_id";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'is_monitored' => 0,
                    'is_sent_to_monitoring' => 0,
                    'user_id' => $user_id,
                ]);
                if ($run) {
                    $sql = "UPDATE classes SET is_monitored=:is_monitored WHERE id=:class_id";
                    $stmt = $this->conn->prepare($sql);
                    $updated = $stmt->execute([
                        'is_monitored' => 0,
                        'class_id' => $class_id,
                    ]);
                    if ($updated) {
                        redirect("monitoring_class_detail.php?class_id=$class_id&user_id=$user_id");
                    }
                }
            }
        }
    }

    private function updateClassMonitoringDuration($activeClass)
    {
        $end_time = date('Y-m-d H:i:s');
        $duration = calculateDuration($activeClass->start_time, $end_time);
        //2016-06-01 22:45:00
        // 2021-04-04 16:34:37
        $final_duration = $duration[0] . ':' . $duration[1] . ':' . $duration[2];


        $sql = "UPDATE classes SET end_time=:end_time, duration=:duration, is_sent_to_monitoring=:is_sent_to_monitoring  WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $run = $stmt->execute([
            'end_time' => $end_time,
            'duration' => $final_duration,
            'is_sent_to_monitoring' => 0,
            'id' => $activeClass->id,
        ]);
        return $run;
    }
}
